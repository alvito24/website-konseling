<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Informasi Konseling') }}</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Siswa') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->siswa->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Jenis Konseling') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($konseling->jenis_konseling) }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Topik') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->topik }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Tanggal & Waktu') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $konseling->tanggal->format('d/m/Y') }} {{ $konseling->waktu }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Status') }}</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $konseling->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($konseling->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($konseling->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Deskripsi') }}</h3>
                            <div class="mt-4 text-sm text-gray-900">
                                {{ $konseling->deskripsi }}
                            </div>
                            
                            @if(auth()->user()->hasRole('guru_bk') && $konseling->status === 'pending')
                                <div class="mt-6 space-x-4">
                                    <form action="{{ route('konseling.accept', $konseling) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            {{ __('Terima') }}
                                        </button>
                                    </form>

                                    <form action="{{ route('konseling.reject', $konseling) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                            {{ __('Tolak') }}
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if(auth()->user()->hasRole('guru_bk') || auth()->id() === $konseling->siswa_id)
                                <div class="mt-6">
                                    <form action="{{ route('chat.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $konseling->siswa_id }}">
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            {{ __('Mulai Chat') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>