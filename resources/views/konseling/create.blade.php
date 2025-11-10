<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Konseling Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('konseling.store') }}" class="space-y-6">
                        @csrf

                        <!-- Jenis Konseling -->
                        <div>
                            <label for="jenis_konseling" class="block text-sm font-medium text-gray-700">
                                Jenis Konseling
                            </label>
                            <select id="jenis_konseling" name="jenis_konseling" required
                                class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Jenis Konseling</option>
                                <option value="akademik">Akademik</option>
                                <option value="karir">Karir</option>
                                <option value="pribadi">Pribadi</option>
                                <option value="sosial">Sosial</option>
                            </select>
                        </div>

                        <!-- Topik Konseling -->
                        <div>
                            <label for="topik" class="block text-sm font-medium text-gray-700">
                                Topik Konseling
                            </label>
                            <input type="text" id="topik" name="topik" required
                                class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                                Deskripsi Masalah
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <!-- Tanggal yang Diinginkan -->
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">
                                Tanggal yang Diinginkan
                            </label>
                            <input type="date" id="tanggal" name="tanggal" required
                                class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Waktu yang Diinginkan -->
                        <div>
                            <label for="waktu" class="block text-sm font-medium text-gray-700">
                                Waktu yang Diinginkan
                            </label>
                            <select id="waktu" name="waktu" required
                                class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Waktu</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Buat Konseling
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>