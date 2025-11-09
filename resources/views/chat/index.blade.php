<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse ($chatRooms as $chatRoom)
                        <div class="mb-4 p-4 border rounded hover:bg-gray-50">
                            <a href="{{ route('chat.show', $chatRoom) }}" class="block">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="font-semibold text-lg">
                                            @if (auth()->id() === $chatRoom->counselor_id)
                                                {{ $chatRoom->student->name }}
                                            @else
                                                {{ $chatRoom->counselor->name }}
                                            @endif
                                        </h3>
                                        @if ($chatRoom->messages->isNotEmpty())
                                            <p class="text-gray-600 text-sm">
                                                {{ Str::limit($chatRoom->messages->last()->message, 50) }}
                                            </p>
                                            <span class="text-gray-400 text-xs">
                                                {{ $chatRoom->messages->last()->created_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <p class="text-gray-400 text-sm">No messages yet</p>
                                        @endif
                                    </div>
                                    @if ($chatRoom->messages->where('read_at', null)->where('user_id', '!=', auth()->id())->count() > 0)
                                        <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">
                                            {{ $chatRoom->messages->where('read_at', null)->where('user_id', '!=', auth()->id())->count() }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No chat rooms available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>