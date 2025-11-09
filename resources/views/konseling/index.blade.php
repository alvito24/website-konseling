<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->role === 'siswa')
                    <div class="mb-4">
                        <a href="{{ route('konseling.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            {{ __('Buat Konseling Baru') }}
                        </a>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($konselings as $konseling)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $konseling->tanggal->format('d/m/Y') }}<br>
                                            <span class="text-sm text-gray-500">{{ $konseling->waktu }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $konseling->siswa->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ ucfirst($konseling->jenis_konseling) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $konseling->topik }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $konseling->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($konseling->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($konseling->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('konseling.show', $konseling) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ __('Detail') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>