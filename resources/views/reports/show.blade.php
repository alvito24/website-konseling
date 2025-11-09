<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.export', ['type' => $type, 'format' => 'pdf'] + request()->all()) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    PDF
                </a>
                <a href="{{ route('reports.export', ['type' => $type, 'format' => 'excel'] + request()->all()) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-500">
                    Excel
                </a>
                <a href="{{ route('reports.export', ['type' => $type, 'format' => 'csv'] + request()->all()) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                    CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($type === 'counselor')
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Laporan Guru BK: {{ $data->first()?->counselor ?? 'Tidak ada data' }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Periode: {{ request('start_date') }} - {{ request('end_date') }}
                            </p>
                        </div>

                        <div class="overflow-x-auto mt-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($data as $session)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['date'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['student'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($session['type']) }}</td>
                                            <td class="px-6 py-4">{{ $session['topic'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $session['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($session['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                       'bg-blue-100 text-blue-800') }}">
                                                    {{ ucfirst($session['status']) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['duration'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    @elseif($type === 'student')
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Laporan Siswa: {{ $data->first()?->student ?? 'Tidak ada data' }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Periode: {{ request('start_date') }} - {{ request('end_date') }}
                            </p>
                        </div>

                        <div class="overflow-x-auto mt-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru BK</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindak Lanjut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($data as $session)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['date'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['counselor'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($session['type']) }}</td>
                                            <td class="px-6 py-4">{{ $session['topic'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $session['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($session['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                       'bg-blue-100 text-blue-800') }}">
                                                    {{ ucfirst($session['status']) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">{{ $session['follow_up'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    @elseif($type === 'category')
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Laporan Kategori: {{ ucfirst(request('category')) }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Periode: {{ request('start_date') }} - {{ request('end_date') }}
                            </p>
                        </div>

                        <div class="overflow-x-auto mt-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru BK</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($data as $session)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['date'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['student'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $session['counselor'] }}</td>
                                            <td class="px-6 py-4">{{ $session['topic'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $session['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($session['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                       'bg-blue-100 text-blue-800') }}">
                                                    {{ ucfirst($session['status']) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">{{ $session['outcome'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>