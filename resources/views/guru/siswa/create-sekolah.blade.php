<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Siswa Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Form Tambah Siswa</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Isi detail siswa baru di bawah ini.
                    </p>

                    <form method="POST" action="{{ route('guru.siswa.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" :value="old('nama_lengkap')" required autofocus autocomplete="nama_lengkap" />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
                        </div>

                        <div>
                            <x-input-label for="nisn" :value="__('NISN')" />
                            <x-text-input id="nisn" name="nisn" type="text" class="mt-1 block w-full" :value="old('nisn')" autocomplete="nisn" />
                            <x-input-error class="mt-2" :messages="$errors->get('nisn')" />
                        </div>

                        <div>
                            <x-input-label for="kelompok_kelas_id" :value="__('Kelompok Kelas')" />
                            <select id="kelompok_kelas_id" name="kelompok_kelas_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kelompok Kelas</option>
                                @foreach ($kelompokKelas as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelompok_kelas_id') == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('kelompok_kelas_id')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
