
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Sekolah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('guru.sekolah.update') }}">
                        @csrf
                        @method('PATCH')

                        <!-- Nama Sekolah -->
                        <div>
                            <x-input-label for="nama_sekolah" :value="__('Nama Sekolah')" />
                            <x-text-input id="nama_sekolah" class="block mt-1 w-full" type="text" name="nama_sekolah" :value="old('nama_sekolah', $sekolah->nama_sekolah)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_sekolah')" class="mt-2" />
                        </div>

                        <!-- Alamat -->
                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat', $sekolah->alamat)" required />
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <!-- NPSN -->
                        <div class="mt-4">
                            <x-input-label for="npsn" :value="__('NPSN')" />
                            <x-text-input id="npsn" class="block mt-1 w-full" type="text" name="npsn" :value="old('npsn', $sekolah->npsn)" required />
                            <x-input-error :messages="$errors->get('npsn')" class="mt-2" />
                        </div>

                        <!-- Kepala Sekolah -->
                        <div class="mt-4">
                            <x-input-label for="kepala_sekolah" :value="__('Kepala Sekolah')" />
                            <x-text-input id="kepala_sekolah" class="block mt-1 w-full" type="text" name="kepala_sekolah" :value="old('kepala_sekolah', $sekolah->kepala_sekolah)" />
                            <x-input-error :messages="$errors->get('kepala_sekolah')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="negeri" {{ old('status', $sekolah->status) == 'negeri' ? 'selected' : '' }}>Negeri</option>
                                <option value="swasta" {{ old('status', $sekolah->status) == 'swasta' ? 'selected' : '' }}>Swasta</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
