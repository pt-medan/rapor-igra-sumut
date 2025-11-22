<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card with Quick Actions -->
            <div class="mb-6 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold">👋 Selamat Datang, {{ Auth::user()->name }}!</h1>
                        <p class="mt-2 text-indigo-100">Kelas: <span class="font-semibold">{{ $kelas->nama_kelompok }}</span> | Sekolah: <span class="font-semibold">{{ $sekolah->nama_sekolah }}</span></p>
                    </div>
                    <!-- Quick Action Buttons -->
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('guru.siswa.create') }}" class="px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition font-semibold text-sm border border-white">
                            ➕ Tambah Siswa
                        </a>
                        <a href="{{ route('guru.siswa.index') }}" class="px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition font-semibold text-sm border border-white">
                            👥 Kelola Siswa
                        </a>
                    </div>
                </div>
            </div>

            <!-- Student Quota Card (if guru has quota) -->
            @if(Auth::user()->guru && Auth::user()->guru->student_quota > 0)
            <div class="mb-6 bg-blue-50 rounded-lg shadow p-4 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-700 font-semibold text-sm mb-1">📊 Kuota Siswa Anda</p>
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-2xl font-bold text-blue-600">{{ $jumlahSiswa }}/{{ Auth::user()->guru->student_quota }}</p>
                                <p class="text-xs text-blue-600">Siswa terdaftar</p>
                            </div>
                            <div class="flex-1 max-w-xs">
                                <div class="w-full bg-gray-300 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition" style="width: {{ ($jumlahSiswa / Auth::user()->guru->student_quota) * 100 }}%"></div>
                                </div>
                            </div>
                            @if($jumlahSiswa >= Auth::user()->guru->student_quota)
                                <div class="text-right">
                                    <p class="text-red-600 font-semibold text-sm">⚠️ Kuota Penuh</p>
                                    <p class="text-xs text-gray-600">Hubungi admin untuk penambahan</p>
                                </div>
                            @else
                                <div class="text-right">
                                    <p class="text-green-600 font-semibold text-sm">{{ Auth::user()->guru->student_quota - $jumlahSiswa }}</p>
                                    <p class="text-xs text-gray-600">Sisa kuota</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Primary Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Siswa -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-blue-500 p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Siswa</p>
                            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $jumlahSiswa }}</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Sudah Dinilai -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-green-500 p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Sudah Dinilai</p>
                            <p class="text-4xl font-bold text-green-600 mt-2">{{ $jumlahDinilai }}/{{ $jumlahSiswa }}</p>
                        </div>
                        <svg class="w-12 h-12 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <!-- Progress Bar -->
                    <div class="mt-4 bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full transition" style="width: {{ $persentaseDinilai }}%"></div>
                    </div>
                </div>

                <!-- Belum Dinilai -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-yellow-500 p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Belum Dinilai</p>
                            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $jumlahBelumDinilai }}</p>
                        </div>
                        <svg class="w-12 h-12 text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89a6 6 0 01-8.954-5.387 6 6 0 18.72.102A6 6 0 0113.477 14.89z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Secondary Stats & Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Quick Action Buttons -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-gray-700 font-semibold mb-4">⚡ Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('guru.siswa.create') }}" class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                            ➕ Tambah Siswa
                        </a>
                        <a href="{{ route('guru.siswa.index') }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                            👥 Lihat Semua Siswa
                        </a>
                        @if($jumlahBelumDinilai > 0)
                            <a href="{{ route('guru.rapor.index') }}" class="block w-full text-center px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-semibold hover:bg-orange-700 transition">
                                📝 Input Rapor
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Periode Penilaian -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-gray-700 font-semibold mb-3">📅 Periode</h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs text-gray-500">Tahun Ajaran</p>
                            <p class="font-bold text-gray-900">{{ $currentTahunAjaran ?? 'Belum dipilih' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Semester</p>
                            <p class="font-bold text-gray-900">{{ $currentSemester ?? 'Belum dipilih' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Completion Status -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-gray-700 font-semibold mb-3">✅ Progress</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Dinilai</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">{{ $jumlahDinilai }}/{{ $jumlahSiswa }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $persentaseDinilai }}%"></div>
                        </div>
                        <p class="text-center text-sm font-bold text-gray-600">{{ $persentaseDinilai }}%</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            @if($recentPenilaians->isNotEmpty())
            <div class="mb-6 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">� Aktivitas Terbaru</h3>
                </div>
                <div class="divide-y divide-gray-200 max-h-64 overflow-y-auto">
                    @foreach($recentPenilaians->take(5) as $penilaian)
                    <div class="px-6 py-3 hover:bg-gray-50 transition flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $penilaian->siswa->nama_lengkap }}</p>
                            <p class="text-xs text-gray-500">{{ $penilaian->updated_at->format('d M Y H:i') }}</p>
                        </div>
                        <a href="{{ route('guru.penilaian.edit', $penilaian) }}" class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded hover:bg-blue-200 transition">
                            Lihat
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Students List (Simplified) -->
            <form action="{{ route('guru.export.rapor.massal') }}" method="POST" id="bulk-export-form">
                @csrf
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center" id="siswa-list">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">📚 Daftar Siswa</h3>
                        </div>
                        <div class="flex gap-2">
                            @if($penilaians->isNotEmpty())
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                    ⬇️ Download Massal
                                </button>
                                <a href="{{ route('guru.export.rapor.kelas', ['kelompok_kelas' => $kelas, 'tahun_ajaran' => $currentTahunAjaran, 'semester' => $currentSemester]) }}" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                                    🖨️ Cetak Semua
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700">
                                        <input type="checkbox" id="select-all" class="rounded">
                                    </th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700">NISN</th>
                                    <th class="px-6 py-3 text-center font-semibold text-gray-700">Status</th>
                                    <th class="px-6 py-3 text-right font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($siswas->take(10) as $siswa)
                                    @php
                                        $penilaian = $penilaians->get($siswa->id);
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            @if ($penilaian)
                                                <input type="checkbox" name="penilaian_ids[]" value="{{ $penilaian->id }}" class="row-checkbox rounded">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $siswa->nisn ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($penilaian)
                                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✅ Dinilai</span>
                                            @else
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">⏳ Belum</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex gap-2 justify-end">
                                                @if ($penilaian)
                                                    <a href="{{ route('guru.penilaian.edit', $penilaian) }}" class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold hover:bg-blue-200 transition">
                                                        Edit
                                                    </a>
                                                @else
                                                    <a href="{{ route('guru.siswa.penilaian.create', $siswa) }}" class="px-2 py-1 bg-green-600 text-white rounded text-xs font-semibold hover:bg-green-700 transition">
                                                        Buat Rapor
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            <p class="text-sm">📭 Belum ada siswa di kelas ini</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($siswas->count() > 10)
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-center">
                        <a href="{{ route('guru.siswa.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Lihat semua siswa →
                        </a>
                    </div>
                    @endif
                </div>
            </form>

            <script>
                document.getElementById('select-all')?.addEventListener('change', function(event) {
                    document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
                        checkbox.checked = event.target.checked;
                    });
                });
            </script>

        </div>
    </div>
</x-app-layout>