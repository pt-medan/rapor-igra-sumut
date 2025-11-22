<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $sekolah->nama_sekolah }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $sekolah->kota }} • {{ $sekolah->alamat }}</p>
            </div>
            <a href="{{ route('admin.provinsi.schools.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- School Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500">Total Guru</h4>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['guru_count'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500">Total Siswa</h4>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['siswa_count'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500">Total Kelas</h4>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['kelas_count'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-2 text-sm font-semibold">
                            @if($stats['guru_count'] > 0)
                                <span class="text-green-600">✓ Aktif</span>
                            @else
                                <span class="text-red-600">✗ Inaktif</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- School Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sekolah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">NPSN</label>
                            <p class="mt-1 text-gray-900">{{ $sekolah->npsn ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Provinsi</label>
                            <p class="mt-1 text-gray-900">{{ $sekolah->provinsi ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Kabupaten/Kota</label>
                            <p class="mt-1 text-gray-900">{{ $sekolah->kota ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Alamat</label>
                            <p class="mt-1 text-gray-900">{{ $sekolah->alamat ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Telepon</label>
                            <p class="mt-1 text-gray-900">{{ $sekolah->telepon ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Email</label>
                            <p class="mt-1 text-gray-900">{{ $sekolah->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gurus Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Guru ({{ $sekolah->gurus->count() }})</h3>
                    @if($sekolah->gurus->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun Pengguna</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($sekolah->gurus as $guru)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $guru->nama_guru }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $guru->user?->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $guru->kelompokKelas?->nama_kelompok ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $guru->kelompokKelas?->siswas->count() ?? 0 }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">Belum ada guru di sekolah ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Classes Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Kelas ({{ $sekolah->kelompokKelas->count() }})</h3>
                    @if($sekolah->kelompokKelas->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($sekolah->kelompokKelas as $kelas)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <h4 class="font-semibold text-gray-900">{{ $kelas->nama_kelompok }}</h4>
                                <p class="text-sm text-gray-600 mt-1">Tahun Ajaran: {{ $kelas->tahun_ajaran }}</p>
                                <p class="text-sm text-gray-600">Wali Kelas: {{ $kelas->waliKelas?->nama_guru ?? '-' }}</p>
                                <p class="text-sm text-gray-600 mt-2">
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                        {{ $kelas->siswas->count() }} Siswa
                                    </span>
                                </p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">Belum ada kelas di sekolah ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Students -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Siswa Terbaru ({{ $sekolah->siswas->count() }})</h3>
                    @if($sekolah->siswas->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Lahir</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($sekolah->siswas->take(10) as $siswa)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $siswa->nama_lengkap }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $siswa->nisn ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $siswa->kelompokKelas?->nama_kelompok ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $siswa->tanggal_lahir?->format('d/m/Y') ?? '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($sekolah->siswas->count() > 10)
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">
                                Menampilkan 10 dari {{ $sekolah->siswas->count() }} siswa
                            </p>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">Belum ada siswa di sekolah ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
