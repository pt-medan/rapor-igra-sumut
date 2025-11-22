<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Admin Provinsi') }}
            </h2>
            <a href="{{ route('admin.provinsi.users.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Kelola Pengguna
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="mb-6 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg shadow-lg p-6 text-white">
                <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="mt-2 text-indigo-100">Ini adalah ringkasan lengkap dari seluruh sistem E-Rapor Provinsi</p>
            </div>

            <!-- Main Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Users Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Total Pengguna</h4>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $jumlahPengguna }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs">
                            <span class="text-green-600 font-semibold">{{ $pengguna_aktif }}</span>
                            <span class="text-gray-500 ml-1">aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Schools Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Total Sekolah</h4>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $jumlahSekolah }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs">
                            <span class="text-green-600 font-semibold">{{ $sekolahAktif }}</span>
                            <span class="text-gray-500 ml-1">aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Gurus Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Total Guru</h4>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $jumlahGuru }}</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs">
                            <span class="text-gray-500">+{{ $guru_trend }}</span>
                            <span class="text-gray-500 ml-1">bulan ini</span>
                        </div>
                    </div>
                </div>

                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Total Siswa</h4>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $jumlahSiswa }}</p>
                            </div>
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25c0 5.079 3.855 9.577 8.75 9.761m0-13c5.5 0 10 4.745 10 10.25 0 5.079-3.855 9.577-8.75 9.761M9 9h.008v.008H9V9m4 0h.008v.008H13V9m4 0h.008v.008H17V9m-4 4h.008v.008H13v-.008m4 0h.008v.008H17v-.008m-4 4h.008v.008H13v-.008m4 0h.008v.008H17v-.008"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs">
                            <span class="text-gray-500">+{{ $siswa_trend }}</span>
                            <span class="text-gray-500 ml-1">bulan ini</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Pending Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Pengguna Pending</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                {{ $pending_users }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">Menunggu validasi admin provinsi</p>
                        <a href="{{ route('admin.provinsi.users.index') }}?status=pending" class="mt-4 inline-block text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Lihat Semua →
                        </a>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Pengguna Aktif</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ $pengguna_aktif }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">Sudah tervalidasi dan aktif</p>
                        <a href="{{ route('admin.provinsi.users.index') }}?status=active" class="mt-4 inline-block text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Lihat Semua →
                        </a>
                    </div>
                </div>

                <!-- School Status -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Sekolah</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Dengan Guru</span>
                                <span class="font-semibold text-gray-900">{{ $sekolah_dengan_guru }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($sekolah_dengan_guru / max($jumlahSekolah, 1)) * 100 }}%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-sm text-gray-600">Tanpa Guru</span>
                                <span class="font-semibold text-gray-900">{{ $sekolah_tanpa_guru }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-600 h-2 rounded-full" style="width: {{ ($sekolah_tanpa_guru / max($jumlahSekolah, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Users List -->
            @if($pending_users_list->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pengguna Pending Terbaru</h3>
                        <a href="{{ route('admin.provinsi.users.index') }}?status=pending" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pending_users_list as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->sekolah?->nama_sekolah ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form method="POST" action="{{ route('admin.provinsi.users.validate', $user) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 font-semibold">
                                                Validasi
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Activity -->
            @if($recent_activity->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        @foreach($recent_activity as $activity)
                        <div class="flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 flex-shrink-0">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $activity->name }} divalidasi
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $activity->sekolah?->nama_sekolah }} • {{ $activity->validated_at?->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.provinsi.schools.index') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg p-6 text-center transition shadow-md">
                    <h4 class="font-semibold mb-1">📚 Kelola Sekolah</h4>
                    <p class="text-sm text-blue-100">Lihat dan kelola semua sekolah</p>
                </a>
                <a href="{{ route('admin.provinsi.users.index') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-lg p-6 text-center transition shadow-md">
                    <h4 class="font-semibold mb-1">👥 Kelola Pengguna</h4>
                    <p class="text-sm text-purple-100">Validasi dan kelola akun pengguna</p>
                </a>
                <a href="{{ route('profile.edit') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg p-6 text-center transition shadow-md">
                    <h4 class="font-semibold mb-1">⚙️ Profil</h4>
                    <p class="text-sm text-green-100">Kelola profil admin</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
