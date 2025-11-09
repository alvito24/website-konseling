@php
$role = auth()->user()->role;
@endphp

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        @if($role == 'admin')
                            Anda masuk sebagai Administrator. Anda dapat mengelola pengguna dan memonitor aktivitas konseling.
                        @elseif($role == 'guru_bk')
                            Anda masuk sebagai Guru BK. Anda dapat mengelola sesi konseling dan melihat laporan siswa.
                        @elseif($role == 'wali_kelas')
                            Anda masuk sebagai Wali Kelas. Anda dapat memonitor perkembangan siswa di kelas Anda.
                        @elseif($role == 'siswa')
                            Anda masuk sebagai Siswa. Anda dapat membuat janji konseling dan melihat riwayat konseling Anda.
                        @elseif($role == 'orangtua')
                            Anda masuk sebagai Orang Tua. Anda dapat memonitor perkembangan anak Anda.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                @if($role == 'admin' || $role == 'guru_bk')
                <!-- Total Konseling -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">25</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Konseling</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Konseling -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                                <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">8</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Menunggu Konfirmasi</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($role == 'siswa')
                <!-- My Konseling -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">5</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Konseling Saya</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Recent Activities -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        <!-- Activity Items -->
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Sesi Konseling Baru</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">2 jam yang lalu</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Konseling Selesai</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">5 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
