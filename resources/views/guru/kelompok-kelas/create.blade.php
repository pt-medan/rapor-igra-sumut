<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kelompok Kelas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('guru.kelompok-kelas.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nama_kelompok" :value="__('Nama Kelas')" />
                                <x-text-input id="nama_kelompok" class="block mt-1 w-full" type="text" name="nama_kelompok" :value="old('nama_kelompok')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_kelompok')" class="mt-2" />
                            </div>
                <div class="mt-4">
                    <x-input-label for="tahun_ajaran" :value="__('Tahun Ajaran')" />
                    <x-text-input id="tahun_ajaran" class="block mt-1 w-full bg-gray-100" type="text" name="tahun_ajaran" :value="'2025/2026'" readonly />
                    <x-input-error :messages="$errors->get('tahun_ajaran')" class="mt-2" />
                </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('guru.kelompok-kelas.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
