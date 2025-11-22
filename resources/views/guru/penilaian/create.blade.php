<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Isi Rapor untuk') }} {{ $siswa->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('guru.siswa.penilaian.store', $siswa) }}" method="POST">
                        @csrf
                        <div class="space-y-8">

                            {{-- Periode Penilaian --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="tahun_ajaran" :value="__('Tahun Ajaran')" />
                                    <x-text-input id="tahun_ajaran" class="block mt-1 w-full bg-gray-100" type="text" name="tahun_ajaran" :value="'2025/2026'" readonly />
                                    <x-input-error :messages="$errors->get('tahun_ajaran')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="semester" :value="__('Semester')" />
                                    <select id="semester" name="semester" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="Ganjil" @if(old('semester') == 'Ganjil') selected @endif>Ganjil</option>
                                        <option value="Genap" @if(old('semester') == 'Genap') selected @endif>Genap</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Aspek Penilaian --}}
                            <div>
                                <x-input-label for="agama_budi_pekerti" :value="__('1. Agama dan Budi Pekerti')" />
                                <textarea id="agama_budi_pekerti" name="agama_budi_pekerti" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('agama_budi_pekerti') }}</textarea>
                                <x-input-error :messages="$errors->get('agama_budi_pekerti')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jati_diri" :value="__('2. Jati Diri')" />
                                <textarea id="jati_diri" name="jati_diri" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('jati_diri') }}</textarea>
                                <x-input-error :messages="$errors->get('jati_diri')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="literasi_sains" :value="__('3. Dasar-dasar Literasi, Matematika, Sains, Teknologi, Rekayasa, dan Seni')" />
                                <textarea id="literasi_sains" name="literasi_sains" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('literasi_sains') }}</textarea>
                                <x-input-error :messages="$errors->get('literasi_sains')" class="mt-2" />
                            </div>

                            {{-- Kehadiran --}}
                            <div>
                                <h4 class="font-medium text-gray-800">Kehadiran</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
                                    <div>
                                        <x-input-label for="sakit" :value="__('Sakit (hari)')" />
                                        <x-text-input id="sakit" class="block mt-1 w-full" type="number" name="sakit" :value="old('sakit', 0)" />
                                        <x-input-error :messages="$errors->get('sakit')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="izin" :value="__('Izin (hari)')" />
                                        <x-text-input id="izin" class="block mt-1 w-full" type="number" name="izin" :value="old('izin', 0)" />
                                        <x-input-error :messages="$errors->get('izin')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="tanpa_keterangan" :value="__('Tanpa Keterangan (hari)')" />
                                        <x-text-input id="tanpa_keterangan" class="block mt-1 w-full" type="number" name="tanpa_keterangan" :value="old('tanpa_keterangan', 0)" />
                                        <x-input-error :messages="$errors->get('tanpa_keterangan')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <x-input-label for="catatan_kesehatan" :value="__('Catatan Kesehatan')" />
                                <textarea id="catatan_kesehatan" name="catatan_kesehatan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan_kesehatan') }}</textarea>
                                <x-input-error :messages="$errors->get('catatan_kesehatan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="catatan_guru" :value="__('Catatan Guru untuk Orang Tua')" />
                                <textarea id="catatan_guru" name="catatan_guru" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan_guru') }}</textarea>
                                <x-input-error :messages="$errors->get('catatan_guru')" class="mt-2" />
                            </div>

                            {{-- Ekstrakurikuler --}}
                            <div>
                                <h4 class="font-medium text-gray-800">Ekstrakurikuler</h4>
                                <div id="ekstrakurikuler-container" class="mt-2 space-y-4">
                                    {{-- Dynamic fields will be added here --}}
                                </div>
                                <button type="button" id="add-ekstra-btn" class="mt-2 text-sm text-indigo-600 hover:text-indigo-900">+ Tambah Ekstrakurikuler</button>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('guru.dashboard') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Rapor') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('ekstrakurikuler-container');
            const addButton = document.getElementById('add-ekstra-btn');
            let ekstraIndex = 0;

            // Function to add a new field
            function addEkstraField(nama = '', predikat = '') {
                const newField = document.createElement('div');
                newField.classList.add('grid', 'grid-cols-1', 'md:grid-cols-3', 'gap-4', 'items-center');
                newField.innerHTML = `
                    <div class="md:col-span-1">
                        <input type="text" name="ekstrakurikuler[${ekstraIndex}][nama]" value="${nama}" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Nama Kegiatan" />
                    </div>
                    <div class="md:col-span-1">
                        <input type="text" name="ekstrakurikuler[${ekstraIndex}][predikat]" value="${predikat}" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Predikat (cth: Baik)" />
                    </div>
                    <div>
                        <button type="button" class="remove-ekstra-btn text-red-500 hover:text-red-700 text-sm">Hapus</button>
                    </div>
                `;
                container.appendChild(newField);
                ekstraIndex++;
            }

            // Load old data if validation fails
            const oldEkstra = {!! json_encode(old('ekstrakurikuler')) !!} || [];
            if (Array.isArray(oldEkstra)) {
                oldEkstra.forEach(item => {
                    addEkstraField(item.nama || '', item.predikat || '');
                });
            }

            // Event listeners
            addButton.addEventListener('click', () => addEkstraField());

            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-ekstra-btn')) {
                    e.target.closest('.grid').remove();
                }
            });
        });
    </script>
</x-app-layout>
