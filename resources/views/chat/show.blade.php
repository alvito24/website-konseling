<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat with 
            @if (auth()->id() === $chatRoom->counselor_id)
                {{ $chatRoom->student->name }}
            @else
                {{ $chatRoom->counselor->name }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col space-y-4 h-96 overflow-y-auto mb-4" id="messages-container">
                        @foreach ($messages->reverse() as $message)
                            <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-3/4 {{ $message->user_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-100' }} rounded-lg px-4 py-2">
                                    <div class="text-sm {{ $message->user_id === auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                                        {{ $message->user->name }} • {{ $message->created_at->diffForHumans() }}
                                    </div>
                                    <div class="mt-1">
                                        {{ $message->message }}
                                    </div>
                                    @if ($message->attachment_path)
                                        <div class="mt-2">
                                            <a href="{{ route('chat.download', $message) }}" 
                                               class="text-sm {{ $message->user_id === auth()->id() ? 'text-blue-100 hover:text-white' : 'text-blue-500 hover:text-blue-700' }} underline">
                                                Download Attachment
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('chat.store', $chatRoom) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="message" class="sr-only">Message</label>
                            <textarea name="message" id="message" rows="3" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <label for="attachment" class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-md">
                                    <span class="text-gray-600">Attach File</span>
                                    <input type="file" name="attachment" id="attachment" class="hidden">
                                </label>
                                <span class="text-sm text-gray-500" id="file-name"></span>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('attachment').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '';
            document.getElementById('file-name').textContent = fileName;
        });

        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    </script>
    @endpush
</x-app-layout>