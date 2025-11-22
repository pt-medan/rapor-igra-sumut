<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Siswa Massal (Import Excel)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="font-semibold text-blue-900 mb-2">Panduan Import Siswa Massal</h3>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>✓ Format file: Excel (.xlsx) atau CSV (.csv)</li>
                            <li>✓ Kolom yang harus ada: nama_lengkap, nisn, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat</li>
                            <li>✓ Format tanggal: YYYY-MM-DD (contoh: 2010-01-15)</li>
                            <li>✓ Jenis kelamin: L (Laki-laki) atau P (Perempuan)</li>
                            <li>✓ File tidak boleh kosong dan minimal 1 baris data</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('guru.siswa.import.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- File Upload -->
                        <div>
                            <x-input-label for="file" :value="__('Pilih File Excel/CSV')" />
                            <input 
                                id="file" 
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="file" 
                                name="file" 
                                accept=".xlsx,.csv"
                                required
                            />
                            <p class="mt-2 text-sm text-gray-500">
                                Format yang didukung: .xlsx, .csv
                            </p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        @if($errors->any())
                            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <h4 class="font-semibold text-red-900 mb-2">Kesalahan Import:</h4>
                                <ul class="text-sm text-red-800 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('guru.siswa.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Upload & Proses') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3">Contoh Format File:</h3>
                        <div class="bg-gray-50 p-4 rounded-lg overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">nama_lengkap</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">nisn</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">tempat_lahir</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">tanggal_lahir</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">jenis_kelamin</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">alamat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">Budi Santoso</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">123456789</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">Jakarta</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">2010-01-15</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">L</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">Jl. Merdeka 123</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">Ani Wijaya</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">987654321</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">Bandung</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">2010-05-20</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">P</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">Jl. Gatot Subroto 456</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <strong>Catatan:</strong> File yang Anda upload harus memiliki kolom header yang sesuai. 
                            Anda bisa mendownload template Excel dengan klik tombol "Export Siswa" di halaman daftar siswa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
