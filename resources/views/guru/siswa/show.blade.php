<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rapor Siswa: {{ $siswa->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Detail Siswa</h3>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama Lengkap</p>
                                <p class="text-base font-medium text-gray-800">{{ $siswa->nama_lengkap }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">NISN</p>
                                <p class="text-base font-medium text-gray-800">{{ $siswa->nisn ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                                <p class="text-base font-medium text-gray-800">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jenis Kelamin</p>
                                <p class="text-base font-medium text-gray-800">{{ $siswa->jenis_kelamin ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Alamat</p>
                                <p class="text-base font-medium text-gray-800">{{ $siswa->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Rapor Penilaian</h3>
                                            <div class="mt-6 flex justify-start">
                        <a href="{{ route('guru.siswa.penilaian.index', $siswa) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Lihat Rapor
                        </a>
                        <a href="{{ route('guru.siswa.penilaian.create', $siswa) }}" class="ml-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            + Tambah Rapor
                        </a>
                    </div>
                            Buat Rapor Baru
                        </a>
                    </div>

                    @if($penilaians->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Ajaran</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($penilaians as $penilaian)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $penilaian->tahun_ajaran }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $penilaian->semester }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('guru.penilaian.print', $penilaian) }}" target="_blank" class="text-green-600 hover:text-green-900">Cetak</a>
                                                <a href="{{ route('guru.penilaian.edit', $penilaian) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
                                                <form action="{{ route('guru.penilaian.destroy', $penilaian) }}" method="POST" class="inline-block ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus rapor ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500">Belum ada data rapor untuk siswa ini.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('guru.siswa.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900">Kembali ke Daftar Siswa</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
