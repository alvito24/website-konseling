<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Notifications\ChatNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ChatController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::where('counselor_id', Auth::id())
            ->orWhere('student_id', Auth::id())
            ->with(['counselor', 'student'])
            ->latest()
            ->get();

        return view('chat.index', compact('chatRooms'));
    }

    public function show(ChatRoom $chatRoom)
    {
        abort_if(!$this->canAccessChatRoom($chatRoom), 403);

        $messages = $chatRoom->messages()
            ->with('user')
            ->latest()
            ->paginate(50);

        return view('chat.show', compact('chatRoom', 'messages'));
    }

    public function store(Request $request, ChatRoom $chatRoom)
    {
        abort_if(!$this->canAccessChatRoom($chatRoom), 403);

        $validated = $request->validate([
            'message' => 'required_without:attachment|string|max:1000',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat-attachments', 'private');
        }

        $message = $chatRoom->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'] ?? '',
            'attachment_path' => $attachmentPath,
        ]);

        // Notify the other participant
        $recipient = Auth::id() === $chatRoom->counselor_id 
            ? $chatRoom->student 
            : $chatRoom->counselor;

        $recipient->notify(new ChatNotification($message));

        return back()->with('success', 'Message sent successfully');
    }

    public function download(ChatMessage $message)
    {
        abort_if(!$this->canAccessChatRoom($message->chatRoom), 403);
        abort_if(!$message->attachment_path, 404);

        return response()->download(
            Storage::disk('private')->path($message->attachment_path)
        );
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        // Ensure the current user is a counselor
        abort_if(!Auth::user()->hasRole('counselor'), 403, 'Only counselors can initiate chats');

        // Check if a chat room already exists
        $chatRoom = ChatRoom::where('counselor_id', Auth::id())
            ->where('student_id', $validated['student_id'])
            ->first();

        if (!$chatRoom) {
            $chatRoom = ChatRoom::create([
                'counselor_id' => Auth::id(),
                'student_id' => $validated['student_id'],
            ]);
        }

        return redirect()->route('chat.show', $chatRoom);
    }

    protected function canAccessChatRoom(ChatRoom $chatRoom)
    {
        return Auth::id() === $chatRoom->counselor_id || 
               Auth::id() === $chatRoom->student_id;
    }
}