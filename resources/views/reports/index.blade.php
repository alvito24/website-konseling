<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Total Sesi</h3>
                        <p class="mt-2 text-3xl font-bold">{{ $reports['overview']['total_sessions'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Sesi konseling keseluruhan</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Sesi Aktif</h3>
                        <p class="mt-2 text-3xl font-bold">{{ $reports['overview']['active_sessions'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Sesi konseling yang sedang berlangsung</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Sesi Selesai</h3>
                        <p class="mt-2 text-3xl font-bold">{{ $reports['overview']['completed_sessions'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Sesi konseling yang telah selesai</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Bulanan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sesi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selesai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Penyelesaian</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reports['monthly'] as $stat)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $stat->year }}/{{ $stat->month }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $stat->total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $stat->completed }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ round(($stat->completed / $stat->total) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Kategori Konseling</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($reports['categories'] as $category)
                            <div class="p-4 border rounded-lg">
                                <h4 class="font-medium text-gray-700">{{ ucfirst($category->jenis_konseling) }}</h4>
                                <p class="text-2xl font-bold mt-2">{{ $category->total }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Counselors -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Guru BK Aktif</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sesi Selesai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reports['counselors'] as $counselor)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $counselor->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $counselor->counseling_sessions_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Export Options -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ekspor Laporan</h3>
                    <form action="{{ route('reports.export') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Laporan</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="overview">Ringkasan</option>
                                    <option value="monthly">Statistik Bulanan</option>
                                    <option value="counselor">Per Guru BK</option>
                                    <option value="student">Per Siswa</option>
                                    <option value="category">Per Kategori</option>
                                </select>
                            </div>

                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-700">Format</label>
                                <select name="format" id="format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Ekspor Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>