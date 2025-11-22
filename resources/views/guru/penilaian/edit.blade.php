<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl md:text-                        </div>

                        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end mt-8 gap-3 sm:gap-4 pt-6 border-t">
                            <a href="{{ route('guru.siswa.penilaian.index', $penilaian->siswa) }}" class="inline-flex justify-center text-center w-full sm:w-auto underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 px-4 py-2">
                                Batal
                            </a>
                            <x-primary-button class="w-full sm:w-auto justify-center">
                                {{ __('Perbarui Rapor') }}
                            </x-primary-button>
                        </div>ray-800 leading-tight px-4 sm:px-0">
            {{ __('Edit Rapor untuk') }} {{ $penilaian->siswa->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900">
                    <form action="{{ route('guru.penilaian.update', $penilaian) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6 sm:space-y-8">

                            {{-- Periode Penilaian --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <x-input-label for="tahun_ajaran" :value="__('Tahun Ajaran')" />
                                    <x-text-input id="tahun_ajaran" class="block mt-1 w-full bg-gray-100 text-sm sm:text-base py-2 px-3 sm:px-4" type="text" name="tahun_ajaran" :value="old('tahun_ajaran', $penilaian->tahun_ajaran)" readonly />
                                    <x-input-error :messages="$errors->get('tahun_ajaran')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="semester" :value="__('Semester')" />
                                    <select id="semester" name="semester" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base py-2 px-3 sm:px-4">
                                        <option value="Ganjil" @if(in_array(old('semester', $penilaian->semester), ['1', 'Ganjil'])) selected @endif>Ganjil</option>
                                        <option value="Genap" @if(in_array(old('semester', $penilaian->semester), ['2', 'Genap'])) selected @endif>Genap</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Aspek Penilaian --}}
                            <div>
                                <x-input-label for="agama_budi_pekerti" :value="__('1. Agama dan Budi Pekerti')" />
                                <textarea id="agama_budi_pekerti" name="agama_budi_pekerti" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base px-3 sm:px-4 py-2">{{ old('agama_budi_pekerti', $penilaian->agama_budi_pekerti) }}</textarea>
                                <x-input-error :messages="$errors->get('agama_budi_pekerti')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jati_diri" :value="__('2. Jati Diri')" />
                                <textarea id="jati_diri" name="jati_diri" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base px-3 sm:px-4 py-2">{{ old('jati_diri', $penilaian->jati_diri) }}</textarea>
                                <x-input-error :messages="$errors->get('jati_diri')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="literasi_sains" :value="__('3. Dasar-dasar Literasi, Matematika, Sains, Teknologi, Rekayasa, dan Seni')" />
                                <textarea id="literasi_sains" name="literasi_sains" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base px-3 sm:px-4 py-2">{{ old('literasi_sains', $penilaian->literasi_sains) }}</textarea>
                                <x-input-error :messages="$errors->get('literasi_sains')" class="mt-2" />
                            </div>

                            {{-- Kehadiran --}}
                            <div class="border-t pt-6">
                                <h3 class="font-semibold text-base sm:text-lg text-gray-800 mb-4">Kehadiran</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                                    <div>
                                        <x-input-label for="sakit" :value="__('Sakit (hari)')" />
                                        <x-text-input id="sakit" class="block mt-1 w-full text-sm sm:text-base py-2 px-3 sm:px-4" type="number" name="sakit" :value="old('sakit', $penilaian->sakit)" />
                                        <x-input-error :messages="$errors->get('sakit')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="izin" :value="__('Izin (hari)')" />
                                        <x-text-input id="izin" class="block mt-1 w-full text-sm sm:text-base py-2 px-3 sm:px-4" type="number" name="izin" :value="old('izin', $penilaian->izin)" />
                                        <x-input-error :messages="$errors->get('izin')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="tanpa_keterangan" :value="__('Tanpa Keterangan (hari)')" />
                                        <x-text-input id="tanpa_keterangan" class="block mt-1 w-full text-sm sm:text-base py-2 px-3 sm:px-4" type="number" name="tanpa_keterangan" :value="old('tanpa_keterangan', $penilaian->tanpa_keterangan)" />
                                        <x-input-error :messages="$errors->get('tanpa_keterangan')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div class="border-t pt-6">
                                <h3 class="font-semibold text-base sm:text-lg text-gray-800 mb-4">Catatan</h3>
                                <div>
                                    <x-input-label for="catatan_kesehatan" :value="__('Catatan Kesehatan')" />
                                    <textarea id="catatan_kesehatan" name="catatan_kesehatan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base px-3 sm:px-4 py-2">{{ old('catatan_kesehatan', $penilaian->catatan_kesehatan) }}</textarea>
                                    <x-input-error :messages="$errors->get('catatan_kesehatan')" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                    <x-input-label for="catatan_guru" :value="__('Catatan Guru untuk Orang Tua')" />
                                    <textarea id="catatan_guru" name="catatan_guru" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base px-3 sm:px-4 py-2">{{ old('catatan_guru', $penilaian->catatan_guru) }}</textarea>
                                    <x-input-error :messages="$errors->get('catatan_guru')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Ekstrakurikuler --}}
                            <div class="border-t pt-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                                    <h3 class="font-semibold text-base sm:text-lg text-gray-800">Ekstrakurikuler</h3>
                                    <button type="button" id="add-ekstra-btn" class="w-full sm:w-auto text-sm text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 sm:px-4 py-1 rounded transition">
                                        + Tambah
                                    </button>
                                </div>
                                <div id="ekstrakurikuler-container" class="mt-2 space-y-3 sm:space-y-4">
                                    {{-- Dynamic fields will be added here --}}
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('guru.siswa.penilaian.index', $penilaian->siswa) }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Perbarui Rapor') }}
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
                newField.classList.add('grid', 'grid-cols-1', 'sm:grid-cols-2', 'md:grid-cols-4', 'gap-3', 'sm:gap-4', 'items-start', 'p-4', 'bg-gray-50', 'rounded-lg', 'border', 'border-gray-200');
                newField.innerHTML = `
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Kegiatan</label>
                        <input type="text" name="ekstrakurikuler[${ekstraIndex}][nama]" value="${nama}" class="block w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" placeholder="cth: Pramuka" />
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Predikat</label>
                        <input type="text" name="ekstrakurikuler[${ekstraIndex}][predikat]" value="${predikat}" class="block w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" placeholder="cth: Baik" />
                    </div>
                    <div class="col-span-1 md:col-span-1 flex pt-6 sm:pt-0">
                        <button type="button" class="remove-ekstra-btn w-full sm:w-auto text-red-600 hover:text-red-800 hover:bg-red-50 text-sm font-medium px-3 py-2 rounded transition">
                            Hapus
                        </button>
                    </div>
                `;
                container.appendChild(newField);
                
                // Add event listener for remove button
                newField.querySelector('.remove-ekstra-btn').addEventListener('click', function() {
                    newField.remove();
                });
                
                ekstraIndex++;
            }

            // Load existing ekstrakurikuler data
            const dataToLoad = {!! json_encode(old('ekstrakurikuler', $penilaian->ekstrakurikuler)) !!} || [];
            if (Array.isArray(dataToLoad)) {
                dataToLoad.forEach(item => {
                    if (typeof item === 'object' && item !== null) {
                        addEkstraField(item.nama || '', item.predikat || '');
                    }
                });
            }

            // Add button event listener
            addButton.addEventListener('click', function(e) {
                e.preventDefault();
                addEkstraField();
            });

            // Event delegation for remove buttons
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-ekstra-btn')) {
                    e.preventDefault();
                    e.target.closest('div').remove();
                }
            });
        });
    </script>
</x-app-layout>
                    if (typeof item === 'object' && item !== null) {
                        addEkstraField(item.nama || '', item.predikat || '');
                    }
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
