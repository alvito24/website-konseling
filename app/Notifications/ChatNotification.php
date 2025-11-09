<?php

namespace App\Notifications;

use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ChatNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $chatMessage;

    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $sender = $this->chatMessage->user;
        $preview = Str::limit($this->chatMessage->message, 50);
        
        return (new MailMessage)
            ->subject('New Chat Message from ' . $sender->name)
            ->line($sender->name . ' has sent you a message:')
            ->line('"' . $preview . '"')
            ->action('View Conversation', route('chat.show', $this->chatMessage->chat_room_id));
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Chat Message',
            'message' => $this->chatMessage->user->name . ' has sent you a message',
            'chat_room_id' => $this->chatMessage->chat_room_id,
            'sender_id' => $this->chatMessage->user_id,
            'preview' => Str::limit($this->chatMessage->message, 50),
        ];
    }
}