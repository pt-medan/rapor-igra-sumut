<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Siswa
        </h2>
    </x-slot>

    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="{{ asset('js/form-persistence.js') }}"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="siswa-form" method="POST" action="{{ route('guru.siswa.update', $siswa) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Kelompok Kelas -->
                        <div>
                            <x-input-label for="kelompok_kelas_id" :value="__('Kelompok Kelas')" />
                            
                            @php
                                $kelasCount = is_countable($kelompokKelas) ? count($kelompokKelas) : 0;
                            @endphp
                            
                            @if($kelasCount == 1)
                                <!-- Hanya 1 kelas, tampilkan readonly -->
                                <x-text-input 
                                    id="kelompok_kelas_id" 
                                    class="block mt-1 w-full bg-gray-100" 
                                    type="text" 
                                    value="{{ $kelompokKelas[0]->nama_kelompok }}" 
                                    readonly 
                                />
                                <input type="hidden" name="kelompok_kelas_id" value="{{ $kelompokKelas[0]->id }}" />
                                <p class="text-xs text-gray-500 mt-1">Kelas Anda (tidak dapat diubah)</p>
                            @elseif($kelasCount > 1)
                                <!-- Multiple kelas - ini seharusnya tidak terjadi untuk guru normal, tapi ditampilkan dropdown untuk emergency -->
                                <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-3">
                                    <p class="text-xs text-yellow-800">⚠️ Peringatan: Anda memiliki {{ $kelasCount }} kelas (ini tidak normal)</p>
                                </div>
                                <select id="kelompok_kelas_id" name="kelompok_kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Kelompok Kelas</option>
                                    @foreach ($kelompokKelas as $kelas)
                                        <option value="{{ $kelas->id }}" {{ old('kelompok_kelas_id', $siswa->kelompok_kelas_id) == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelompok }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <!-- Tidak ada kelas -->
                                <div class="bg-red-50 border border-red-200 rounded p-3">
                                    <p class="text-xs text-red-800">❌ Error: Tidak ada kelas yang ditemukan. Hubungi admin.</p>
                                </div>
                            @endif
                            
                            <x-input-error :messages="$errors->get('kelompok_kelas_id')" class="mt-2" />
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mt-4">
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $siswa->nama_lengkap)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                        </div>

                        <!-- NISN -->
                        <div class="mt-4">
                            <x-input-label for="nisn" :value="__('NISN')" />
                            <x-text-input id="nisn" class="block mt-1 w-full" type="text" name="nisn" :value="old('nisn', $siswa->nisn)" />
                            <x-input-error :messages="$errors->get('nisn')" class="mt-2" />
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="mt-4">
                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                            <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $siswa->tempat_lahir)" />
                            <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $siswa->tanggal_lahir)" />
                            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mt-4">
                            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                            <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                        </div>

                        <!-- Alamat -->
                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $siswa->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('guru.siswa.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Form Persistence
        document.addEventListener('DOMContentLoaded', function() {
            FormPersistence.init('siswa-form', {
                storageKey: 'siswa_edit_form_data',
                autoSaveDelay: 500
            });
        });
    </script>
</x-app-layout>
