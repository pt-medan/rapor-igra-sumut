<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight px-4 sm:px-0">
            Manajemen Siswa
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-start" role="alert">
                            <span class="text-lg mr-3">✓</span>
                            <span class="block sm:inline text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($kelas)
                        <div class="mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900">
                                    Daftar Siswa Kelas: <span class="font-semibold">{{ $kelas->nama_kelompok }}</span>
                                </h3>
                                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                                    <a href="{{ route('guru.siswa.create') }}" class="inline-flex justify-center items-center px-3 sm:px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring ring-gray-300 transition text-center">
                                        + Tambah Siswa
                                    </a>
                                    <a href="{{ route('guru.siswa.import.show') }}" class="inline-flex justify-center items-center px-3 sm:px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring ring-green-300 transition text-center">
                                        📥 Massal
                                    </a>
                                    <a href="{{ route('guru.siswa.export') }}" class="inline-flex justify-center items-center px-3 sm:px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition text-center">
                                        📥 Export
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if($siswas->count() > 0)
                            <div class="overflow-x-auto -mx-4 sm:mx-0 sm:rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50 sticky top-0">
                                        <tr>
                                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Nama Lengkap
                                            </th>
                                            <th scope="col" class="hidden sm:table-cell px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                NISN
                                            </th>
                                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($siswas as $siswa)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm font-medium text-gray-900">
                                                    {{ $siswa->nama_lengkap }}
                                                    <div class="sm:hidden text-xs text-gray-600 mt-1">NISN: {{ $siswa->nisn ?? '-' }}</div>
                                                </td>
                                                <td class="hidden sm:table-cell px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-600">
                                                    {{ $siswa->nisn ?? '-' }}
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm font-medium">
                                                    <div class="flex flex-wrap gap-2">
                                                        <a href="{{ route('guru.siswa.penilaian.create', $siswa) }}" class="text-blue-600 hover:text-blue-900 hover:underline text-xs sm:text-sm">Rapor</a>
                                                        @php
                                                            $penilaian = $siswa->penilaians->first();
                                                        @endphp
                                                        @if($penilaian)
                                                            <a href="{{ route('guru.penilaian.print', $penilaian) }}" class="text-green-600 hover:text-green-900 hover:underline text-xs sm:text-sm" target="_blank">Cetak</a>
                                                        @endif
                                                        <a href="{{ route('guru.siswa.edit', $siswa) }}" class="text-indigo-600 hover:text-indigo-900 hover:underline text-xs sm:text-sm">Edit</a>
                                                        <form action="{{ route('guru.siswa.destroy', $siswa) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 hover:underline text-xs sm:text-sm" onclick="return confirm('Yakin hapus siswa ini?')">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-xs sm:text-sm text-gray-600">
                                Total: {{ $siswas->count() }} siswa
                            </div>
                        @else
                            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg text-sm">
                                <p class="font-semibold">Belum ada siswa</p>
                                <p>Kelas ini belum memiliki siswa. Tambahkan siswa baru atau import dari file.</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-r-lg">
                            <p class="font-bold text-sm">⚠️ Perhatian</p>
                            <p class="text-sm mt-1">Anda saat ini tidak ditugaskan sebagai wali kelas. Silakan hubungi Admin Sekolah.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
