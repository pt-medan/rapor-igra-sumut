<x-guest-layout>
    {{-- Include Choices.js CSS for searchable dropdowns --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    
    {{-- Include Toast and FormPersistence Scripts --}}
    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="{{ asset('js/form-persistence.js') }}"></script>
    
    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        {{-- USER DETAILS --}}
        <h2 class="text-lg font-semibold">Detail Pengguna</h2>
        <div class="space-y-4 mt-2">
            <!-- Nama Lengkap -->
            <div>
                <label class="inline-flex font-medium text-sm text-gray-700">
                    <span class="text-red-500">*</span> Nama Lengkap
                </label>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <label class="inline-flex font-medium text-sm text-gray-700">
                    <span class="text-red-500">*</span> Email
                </label>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <!-- Role -->
            <div>
                <label class="inline-flex font-medium text-sm text-gray-700">
                    <span class="text-red-500">*</span> Mendaftar sebagai
                </label>
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="guru" @if(old('role') == 'guru') selected @endif>Guru</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
        </div>

        <hr class="my-6">

        {{-- SCHOOL DETAILS --}}
        <h2 class="text-lg font-semibold">Detail Sekolah</h2>
        <div class="space-y-4 mt-2">
            <!-- School Selection Logic -->
            <div>
                <label for="register_new_school" class="inline-flex items-center">
                    <input id="register_new_school" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="register_new_school" @if(old('register_new_school')) checked @endif>
                    <span class="ms-2 text-sm text-gray-600">Daftarkan Sekolah Baru (jika belum ada di daftar)</span>
                </label>
            </div>

            <!-- Existing School Dropdown -->
            <div id="existing_school_fields">
                <label class="inline-flex font-medium text-sm text-gray-700">
                    <span class="text-red-500">*</span> Pilih Sekolah Anda
                </label>
                <select id="sekolah_id" name="sekolah_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" @if(old('sekolah_id') == $sekolah->id) selected @endif>{{ $sekolah->nama_sekolah }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('sekolah_id')" class="mt-2" />
            </div>

            <!-- New School Form Fields (Initially Hidden) -->
            <div id="new_school_fields" style="display: none;" class="space-y-4 border-t pt-4">
                <!-- Nama Sekolah Baru -->
                <div>
                    <label class="inline-flex font-medium text-sm text-gray-700">
                        <span class="text-red-500">*</span> Nama Sekolah Baru
                    </label>
                    <x-text-input id="nama_sekolah" class="block mt-1 w-full" type="text" name="nama_sekolah" :value="old('nama_sekolah')" />
                    <x-input-error :messages="$errors->get('nama_sekolah')" class="mt-2" />
                </div>

                <!-- NPSN -->
                <div>
                    <label class="inline-flex font-medium text-sm text-gray-700">
                        <span class="text-red-500">*</span> NPSN
                    </label>
                    <x-text-input id="npsn" class="block mt-1 w-full" type="text" name="npsn" :value="old('npsn')" />
                    <x-input-error :messages="$errors->get('npsn')" class="mt-2" />
                </div>

                <!-- Alamat -->
                <div>
                    <label class="inline-flex font-medium text-sm text-gray-700">Alamat Sekolah</label>
                    <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <!-- Provinsi -->
                <div>
                    <label for="provinsi" class="inline-flex font-medium text-sm text-gray-700">
                        <span class="text-red-500">*</span> Provinsi
                    </label>
                    <select id="provinsi" name="provinsi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                    <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                </div>

                <!-- Kabupaten/Kota -->
                <div>
                    <label for="kabupaten" class="inline-flex font-medium text-sm text-gray-700">
                        <span class="text-red-500">*</span> Kabupaten/Kota
                    </label>
                    <select id="kabupaten" name="kabupaten" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Kabupaten/Kota --</option>
                    </select>
                    <x-input-error :messages="$errors->get('kabupaten')" class="mt-2" />
                </div>

                <!-- Nama Kepala Sekolah -->
                <div>
                    <label class="inline-flex font-medium text-sm text-gray-700">Nama Kepala Sekolah</label>
                    <x-text-input id="kepala_sekolah" class="block mt-1 w-full" type="text" name="kepala_sekolah" :value="old('kepala_sekolah')" />
                    <x-input-error :messages="$errors->get('kepala_sekolah')" class="mt-2" />
                </div>

                <!-- Status Sekolah -->
                <div>
                    <label for="status_sekolah" class="inline-flex font-medium text-sm text-gray-700">
                        <span class="text-red-500">*</span> Status Sekolah
                    </label>
                    <select id="status_sekolah" name="status_sekolah" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Status --</option>
                        <option value="negeri" @if(old('status_sekolah') == 'negeri') selected @endif>Negeri</option>
                        <option value="swasta" @if(old('status_sekolah') == 'swasta') selected @endif>Swasta</option>
                    </select>
                    <x-input-error :messages="$errors->get('status_sekolah')" class="mt-2" />
                </div>
            </div>
        </div>

        {{-- CLASS DETAILS (for Guru role) --}}
        <div id="guru_fields" style="display: none;" class="mt-6">
            <hr class="my-6">
            <h2 class="text-lg font-semibold">Detail Kelas</h2>
            <div class="space-y-4 mt-2">
                <div>
                    <label for="kelompok_kelas_id" class="inline-flex font-medium text-sm text-gray-700">
                        <span class="text-red-500">*</span> Pilih Kelas yang Akan Diampu
                    </label>
                    <select id="kelompok_kelas_id" name="kelompok_kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        {{-- Options will be populated by JS --}}
                    </select>
                    <x-input-error :messages="$errors->get('kelompok_kelas_id')" class="mt-2" />
                </div>
                <div id="new_kelas_fields" style="display: none;" class="space-y-4">
                    <div>
                        <label class="inline-flex font-medium text-sm text-gray-700">
                            <span class="text-red-500">*</span> Nama Kelas Baru
                        </label>
                        <x-text-input id="nama_kelompok_kelas_baru" class="block mt-1 w-full" type="text" name="nama_kelompok_kelas_baru" :value="old('nama_kelompok_kelas_baru')" />
                        <x-input-error :messages="$errors->get('nama_kelompok_kelas_baru')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-6">

        {{-- PASSWORD --}}
        <h2 class="text-lg font-semibold">Kata Sandi</h2>
        <div class="space-y-4 mt-2">
            <!-- Password -->
            <div>
                <label class="inline-flex font-medium text-sm text-gray-700">
                    <span class="text-red-500">*</span> Kata Sandi
                </label>
                <div class="relative">
                    <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" />
                    <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-target="password">
                        <svg class="eye-closed w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg class="eye-open w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM19.5 13.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter, harus mengandung huruf besar, huruf kecil, angka, dan simbol.</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="inline-flex font-medium text-sm text-gray-700">
                    <span class="text-red-500">*</span> Konfirmasi Kata Sandi
                </label>
                <div class="relative">
                    <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-target="password_confirmation">
                        <svg class="eye-closed w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg class="eye-open w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM19.5 13.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Daftar
            </button>
        </div>
    </form>

    {{-- Include Choices.js JS for searchable dropdowns --}}
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Form Persistence
            FormPersistence.init('registerForm', {
                storageKey: 'register_form_data',
                autoSaveDelay: 500
            });

            // Element selectors
            const roleSelect = document.getElementById('role');
            const guruFields = document.getElementById('guru_fields');
            const sekolahSelect = document.getElementById('sekolah_id');
            const kelasSelect = document.getElementById('kelompok_kelas_id');
            const newKelasFields = document.getElementById('new_kelas_fields');
            const newKelasInput = document.getElementById('nama_kelompok_kelas_baru');
            const registerNewSchoolCheckbox = document.getElementById('register_new_school');
            const existingSchoolFields = document.getElementById('existing_school_fields');
            const newSchoolFields = document.getElementById('new_school_fields');
            const newSchoolInputs = newSchoolFields.querySelectorAll('input, select');
            
            // Provinsi & Kabupaten
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten');

            // Initialize Choices.js for searchable dropdowns
            const sekolahChoices = new Choices(sekolahSelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari sekolah...',
                shouldSort: false,
                noResultsText: 'Tidak ada hasil',
                noChoicesText: 'Tidak ada pilihan',
                itemSelectText: 'Pilih',
            });

            // Handle sekolah search with custom callback
            sekolahSelect.addEventListener('search', async function (event) {
                const query = event.detail.value;
                if (query.length > 0) {
                    try {
                        const response = await fetch(`/api/sekolah/search?q=${encodeURIComponent(query)}`);
                        const results = await response.json();
                        
                        const choices = results.map(sekolah => ({
                            value: sekolah.id,
                            label: sekolah.nama_sekolah,
                        }));
                        
                        sekolahChoices.setChoices(choices, 'value', 'label', true);
                    } catch (error) {
                        console.error('Error searching sekolah:', error);
                    }
                }
            });

            const kelasChoices = new Choices(kelasSelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari kelas...',
                shouldSort: false,
                noResultsText: 'Tidak ada hasil',
                noChoicesText: 'Tidak ada pilihan',
                itemSelectText: 'Pilih',
            });

            const provinsiChoices = new Choices(provinsiSelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari provinsi...',
                shouldSort: false,
                noResultsText: 'Tidak ada hasil',
                noChoicesText: 'Tidak ada pilihan',
                itemSelectText: 'Pilih',
            });

            const kabupatenChoices = new Choices(kabupatenSelect, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari kabupaten/kota...',
                shouldSort: false,
                noResultsText: 'Tidak ada hasil',
                noChoicesText: 'Tidak ada pilihan',
                itemSelectText: 'Pilih',
            });

            // Load Provinsi on page load
            loadProvinsi();

            // --- School Toggle Logic ---
            function toggleSchoolFields() {
                if (registerNewSchoolCheckbox.checked) {
                    existingSchoolFields.style.display = 'none';
                    newSchoolFields.style.display = 'block';
                    sekolahSelect.disabled = true;
                    newSchoolInputs.forEach(input => input.disabled = false);
                } else {
                    existingSchoolFields.style.display = 'block';
                    newSchoolFields.style.display = 'none';
                    sekolahSelect.disabled = false;
                    newSchoolInputs.forEach(input => input.disabled = true);
                }
                updateGuruFieldsVisibility();
            }

            // --- Load Provinsi ---
            async function loadProvinsi() {
                try {
                    const response = await fetch('/api/provinsi');
                    const provinsiData = await response.json();
                    
                    // Clear existing options (keep placeholder)
                    provinsiChoices.clearStore();
                    
                    // Add placeholder
                    provinsiChoices.setChoices(
                        provinsiData.map(prov => ({
                            value: prov.id,
                            label: prov.name,
                        })),
                        'value',
                        'label',
                        false
                    );
                } catch (error) {
                    console.error('Error loading provinsi:', error);
                }
            }

            // --- Load Kabupaten when Provinsi changes ---
            provinsiSelect.addEventListener('change', async function () {
                const provinsiId = this.value;
                kabupatenChoices.clearStore();
                kabupatenSelect.value = '';

                if (!provinsiId) return;

                try {
                    const response = await fetch(`/api/provinsi/${provinsiId}/kabupaten`);
                    const kabupatenData = await response.json();
                    
                    kabupatenChoices.setChoices(
                        kabupatenData.map((kab, index) => ({
                            value: kab,
                            label: kab,
                        })),
                        'value',
                        'label',
                        false
                    );
                } catch (error) {
                    console.error('Error loading kabupaten:', error);
                }
            });

            // --- Guru Fields Logic ---
            async function fetchKelas(sekolahId) {
                kelasChoices.clearStore();
                
                if (!sekolahId) {
                    kelasSelect.innerHTML = '<option value="">-- Pilih Sekolah Terlebih Dahulu --</option>';
                    kelasChoices.init();
                    return;
                }

                try {
                    const response = await fetch(`/api/sekolah/${sekolahId}/kelas`);
                    const data = await response.json();
                    
                    const choices = [];
                    data.forEach(kelas => {
                        choices.push({
                            value: kelas.id,
                            label: kelas.nama_kelompok,
                        });
                    });
                    choices.push({
                        value: 'new_class',
                        label: '** Buat Kelas Baru **',
                    });

                    kelasChoices.setChoices(choices, 'value', 'label', false);

                } catch (error) {
                    console.error('Error fetching kelas:', error);
                    kelasSelect.innerHTML = '<option value="">Gagal memuat kelas</option>';
                }
            }

            function toggleNewKelasField() {
                if (kelasSelect.value === 'new_class') {
                    newKelasFields.style.display = 'block';
                    newKelasInput.disabled = false;
                } else {
                    newKelasFields.style.display = 'none';
                    newKelasInput.disabled = true;
                }
            }

            function updateGuruFieldsVisibility() {
                const isGuru = roleSelect.value === 'guru';
                const isNewSchool = registerNewSchoolCheckbox.checked;
                const existingSchoolSelected = sekolahSelect.value !== '';

                if (isGuru && (isNewSchool || existingSchoolSelected)) {
                    guruFields.style.display = 'block';
                    if (isNewSchool) {
                        kelasChoices.clearStore();
                        kelasChoices.setChoices([
                            {
                                value: 'new_class',
                                label: '** Buat Kelas Baru **',
                            }
                        ], 'value', 'label', false);
                        kelasSelect.value = 'new_class';
                        toggleNewKelasField();
                    } else {
                        fetchKelas(sekolahSelect.value);
                    }
                } else {
                    guruFields.style.display = 'none';
                }
            }

            // --- Form Validation ---
            document.getElementById('registerForm').addEventListener('submit', function (e) {
                let isValid = true;
                const errors = [];

                // Check required fields
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirmation').value;
                const isNewSchool = registerNewSchoolCheckbox.checked;
                const isGuru = roleSelect.value === 'guru';

                if (!name) {
                    errors.push('Nama Lengkap wajib diisi');
                    isValid = false;
                }

                if (!email) {
                    errors.push('Email wajib diisi');
                    isValid = false;
                }

                if (!password) {
                    errors.push('Kata Sandi wajib diisi');
                    isValid = false;
                }

                if (password !== passwordConfirm) {
                    errors.push('Kata Sandi dan Konfirmasi tidak cocok');
                    isValid = false;
                }

                if (isNewSchool) {
                    const namaSekolah = document.getElementById('nama_sekolah').value.trim();
                    const provinsi = provinsiSelect.value;
                    const kabupaten = kabupatenSelect.value;
                    const status = document.getElementById('status_sekolah').value;

                    if (!namaSekolah) {
                        errors.push('Nama Sekolah Baru wajib diisi');
                        isValid = false;
                    }
                    if (!provinsi) {
                        errors.push('Provinsi wajib dipilih');
                        isValid = false;
                    }
                    if (!kabupaten) {
                        errors.push('Kabupaten/Kota wajib dipilih');
                        isValid = false;
                    }
                    if (!status) {
                        errors.push('Status Sekolah wajib dipilih');
                        isValid = false;
                    }
                } else {
                    if (!sekolahSelect.value) {
                        errors.push('Sekolah wajib dipilih');
                        isValid = false;
                    }
                }

                if (isGuru) {
                    if (!kelasSelect.value) {
                        errors.push('Kelas wajib dipilih');
                        isValid = false;
                    }
                    if (kelasSelect.value === 'new_class') {
                        const namaKelas = document.getElementById('nama_kelompok_kelas_baru').value.trim();
                        if (!namaKelas) {
                            errors.push('Nama Kelas Baru wajib diisi');
                            isValid = false;
                        }
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi formulir:\n\n' + errors.join('\n'));
                }
            });

            // Password Toggle Event Listeners
            document.querySelectorAll('.password-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const fieldId = this.getAttribute('data-target');
                    const inputField = document.getElementById(fieldId);
                    const eyeClosed = this.querySelector('.eye-closed');
                    const eyeOpen = this.querySelector('.eye-open');

                    if (inputField.type === 'password') {
                        inputField.type = 'text';
                        eyeClosed.classList.add('hidden');
                        eyeOpen.classList.remove('hidden');
                    } else {
                        inputField.type = 'password';
                        eyeClosed.classList.remove('hidden');
                        eyeOpen.classList.add('hidden');
                    }
                });
            });

            // Event Listeners
            registerNewSchoolCheckbox.addEventListener('change', toggleSchoolFields);
            roleSelect.addEventListener('change', updateGuruFieldsVisibility);
            sekolahSelect.addEventListener('change', updateGuruFieldsVisibility);
            kelasSelect.addEventListener('change', toggleNewKelasField);

            // Initial state calls
            toggleSchoolFields();
            updateGuruFieldsVisibility();
            toggleNewKelasField();
        });
    </script>
</x-guest-layout>