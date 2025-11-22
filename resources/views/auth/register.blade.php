<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- USER DETAILS --}}
        <h2 class="text-lg font-semibold">Detail Pengguna</h2>
        <div class="space-y-4 mt-2">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <!-- Role -->
            <div>
                <x-input-label for="role" :value="__('Mendaftar sebagai')" />
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
                    <span class="ms-2 text-sm text-gray-600">{{ __('Daftarkan Sekolah Baru (jika belum ada di daftar)') }}</span>
                </label>
            </div>

            <!-- Existing School Dropdown -->
            <div id="existing_school_fields">
                <x-input-label for="sekolah_id" :value="__('Pilih Sekolah Anda')" />
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
                <div>
                    <x-input-label for="nama_sekolah" :value="__('Nama Sekolah Baru')" />
                    <x-text-input id="nama_sekolah" class="block mt-1 w-full" type="text" name="nama_sekolah" :value="old('nama_sekolah')" />
                    <x-input-error :messages="$errors->get('nama_sekolah')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="npsn" :value="__('NPSN')" />
                    <x-text-input id="npsn" class="block mt-1 w-full" type="text" name="npsn" :value="old('npsn')" />
                    <x-input-error :messages="$errors->get('npsn')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="alamat" :value="__('Alamat Sekolah')" />
                    <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="provinsi" :value="__('Provinsi')" />
                    <x-text-input id="provinsi" class="block mt-1 w-full" type="text" name="provinsi" :value="old('provinsi')" />
                    <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="kabupaten" :value="__('Kabupaten/Kota')" />
                    <x-text-input id="kabupaten" class="block mt-1 w-full" type="text" name="kabupaten" :value="old('kabupaten')" />
                    <x-input-error :messages="$errors->get('kabupaten')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="kepala_sekolah" :value="__('Nama Kepala Sekolah')" />
                    <x-text-input id="kepala_sekolah" class="block mt-1 w-full" type="text" name="kepala_sekolah" :value="old('kepala_sekolah')" />
                    <x-input-error :messages="$errors->get('kepala_sekolah')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="status_sekolah" :value="__('Status Sekolah')" />
                    <select id="status_sekolah" name="status_sekolah" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
            <h2 class="text-lg font-semibold">Detail Kelas (Khusus Guru)</h2>
            <div class="space-y-4 mt-2">
                <div>
                    <x-input-label for="kelompok_kelas_id" :value="__('Pilih Kelas yang Akan Diampu')" />
                    <select id="kelompok_kelas_id" name="kelompok_kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        {{-- Options will be populated by JS --}}
                    </select>
                </div>
                <div id="new_kelas_fields" style="display: none;" class="space-y-4">
                    <div>
                        <x-input-label for="nama_kelompok_kelas_baru" :value="__('Nama Kelas Baru')" />
                        <x-text-input id="nama_kelompok_kelas_baru" class="block mt-1 w-full" type="text" name="nama_kelompok_kelas_baru" :value="old('nama_kelompok_kelas_baru')" />
                        <x-input-error :messages="$errors->get('nama_kelompok_kelas_baru')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-6">

        {{-- PASSWORD --}}
        <h2 class="text-lg font-semibold">Password</h2>
        <div class="space-y-4 mt-2">
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                updateGuruFieldsVisibility(); // Also update guru fields when school selection changes
            }
            

            // --- Guru Fields Logic ---
            async function fetchKelas(sekolahId) {
                kelasSelect.innerHTML = '<option>Loading...</option>';
                if (!sekolahId) {
                    kelasSelect.innerHTML = '<option value="">-- Pilih Sekolah Terlebih Dahulu --</option>';
                    return;
                }

                try {
                    const response = await fetch(`/api/sekolah/${sekolahId}/kelas`);
                    const data = await response.json();
                    
                    kelasSelect.innerHTML = ''; // Clear options
                    kelasSelect.add(new Option('-- Pilih Kelas --', ''));
                    data.forEach(kelas => {
                        kelasSelect.add(new Option(kelas.nama_kelompok, kelas.id));
                    });
                    kelasSelect.add(new Option('**Buat Kelas Baru**', 'new_class'));

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
                        // If it's a new school, there are no classes to fetch.
                        // Force the "Create New Class" option.
                        kelasSelect.innerHTML = ''; // Clear options
                        kelasSelect.add(new Option('**Buat Kelas Baru**', 'new_class'));
                        kelasSelect.value = 'new_class';
                        toggleNewKelasField();
                    } else {
                        // If an existing school is selected, fetch its classes.
                        fetchKelas(sekolahSelect.value);
                    }
                } else {
                    guruFields.style.display = 'none';
                }
            }

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