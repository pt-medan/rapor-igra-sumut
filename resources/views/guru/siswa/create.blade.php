<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight px-4 sm:px-0">
            Tambah Siswa Baru
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Toast Notification Container -->
            <div id="toast-container" class="fixed top-4 right-4 z-50"></div>

            <!-- Quota Information Card -->
            @if($quotaInfo)
                <div class="mb-6">
                    @if($quotaInfo['is_unlimited'])
                        <!-- Unlimited Quota -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 sm:p-6">
                            <div class="flex items-start gap-3 sm:gap-4">
                                <div class="flex-shrink-0 pt-1">
                                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm sm:text-base font-medium text-green-900">
                                        ✅ Kuota siswa: <strong>Tidak terbatas</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($quotaInfo['is_full'])
                        <!-- Full Quota - Error -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 sm:p-6">
                            <div class="flex items-start gap-3 sm:gap-4">
                                <div class="flex-shrink-0 pt-1">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm sm:text-base font-medium text-red-900">
                                        ❌ <strong>Kuota siswa penuh!</strong>
                                    </p>
                                    <p class="text-xs sm:text-sm text-red-800 mt-2">
                                        Anda telah mencapai batas maksimal {{ $quotaInfo['quota'] }} siswa. Hubungi admin provinsi untuk menambah kuota.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Normal Quota Display -->
                        @php
                            $usagePercent = $quotaInfo['quota'] > 0 ? round(($quotaInfo['used'] / $quotaInfo['quota']) * 100) : 0;
                            $isWarning = $usagePercent >= 80;
                            $bgColor = $isWarning ? 'bg-yellow-50' : 'bg-blue-50';
                            $borderColor = $isWarning ? 'border-yellow-200' : 'border-blue-200';
                            $textColor = $isWarning ? 'text-yellow-900' : 'text-blue-900';
                            $warningIcon = $isWarning ? '⚠️' : 'ℹ️';
                        @endphp
                        <div class="{{ $bgColor }} border {{ $borderColor }} rounded-lg p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <div class="flex items-start gap-3 sm:gap-4 flex-1">
                                    <div class="flex-shrink-0 text-lg pt-0.5">
                                        {{ $warningIcon }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold {{ $textColor }}">
                                            Kuota Siswa Anda
                                        </p>
                                        <p class="text-sm sm:text-base {{ $textColor }} mt-2">
                                            <strong>{{ $quotaInfo['used'] }}/{{ $quotaInfo['quota'] }}</strong> siswa terdaftar
                                            ({{ $quotaInfo['remaining'] }} tempat tersisa)
                                        </p>
                                        @if($isWarning)
                                            <p class="text-sm {{ $textColor }} mt-2 font-semibold">
                                                ⚠️ Kuota Anda hampir penuh ({{ $usagePercent }}%)
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <!-- Progress Bar -->
                                <div class="w-full sm:w-32 flex-shrink-0">
                                    <div class="w-full bg-gray-300 rounded-full h-2.5">
                                        <div 
                                            class="h-2.5 rounded-full transition-all {{ $isWarning ? 'bg-yellow-500' : 'bg-blue-500' }}"
                                            style="width: {{ min($usagePercent, 100) }}%"
                                        ></div>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1 text-right">{{ $usagePercent }}%</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900">
                    @if($quotaInfo && $quotaInfo['is_full'])
                        <!-- Disable form jika kuota penuh -->
                        <div class="text-center py-8 sm:py-12">
                            <svg class="mx-auto h-12 w-12 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-11a9 9 0 110 18 9 9 0 010-18z" />
                            </svg>
                            <h3 class="mt-4 text-base sm:text-lg font-medium text-gray-900">Kuota Penuh</h3>
                            <p class="mt-2 text-sm text-gray-600 max-w-md mx-auto">
                                Anda tidak dapat menambah siswa baru karena kuota sudah penuh.
                            </p>
                            <p class="mt-1 text-sm text-gray-600 max-w-md mx-auto">
                                Hubungi admin provinsi untuk meningkatkan kuota siswa Anda.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('guru.siswa.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition">
                                    ← Kembali
                                </a>
                            </div>
                        </div>
                    @else
                        <form id="siswa-form" method="POST" action="{{ route('guru.siswa.store') }}">
                            @csrf

                            <!-- Kelompok Kelas -->
                            <div class="mb-6">
                                <x-input-label for="kelompok_kelas_id" :value="__('Kelompok Kelas')" />
                                @php
                                    $kelasCount = is_countable($kelompokKelas) ? count($kelompokKelas) : 0;
                                @endphp
                                
                                @if($kelasCount == 1)
                                    <!-- Hanya 1 kelas, tampilkan readonly -->
                                    <x-text-input 
                                        id="kelompok_kelas_id" 
                                        class="block mt-1 w-full bg-gray-100 text-sm sm:text-base py-2 px-3 sm:px-4" 
                                        type="text" 
                                        value="{{ $kelompokKelas[0]->nama_kelompok }}" 
                                        readonly 
                                    />
                                    <input type="hidden" name="kelompok_kelas_id" value="{{ $kelompokKelas[0]->id }}" />
                                    <p class="text-xs text-gray-500 mt-1">Kelas Anda (tidak dapat diubah)</p>
                                @elseif($kelasCount > 1)
                                    <!-- Multiple kelas - dropdown -->
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-3">
                                        <p class="text-xs text-yellow-800">⚠️ Peringatan: Anda memiliki {{ $kelasCount }} kelas (tidak normal)</p>
                                    </div>
                                    <select id="kelompok_kelas_id" name="kelompok_kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base py-2 px-3 sm:px-4" required>
                                        <option value="">Pilih Kelompok Kelas Anda</option>
                                        @foreach ($kelompokKelas as $kelas)
                                            <option value="{{ $kelas->id }}" {{ old('kelompok_kelas_id') == $kelas->id ? 'selected' : '' }}>
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

                            <!-- Form Fields Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mt-6">
                                <!-- Nama Lengkap -->
                                <div class="md:col-span-2">
                                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                                    <x-text-input id="nama_lengkap" class="block mt-1 w-full text-sm sm:text-base py-2 px-3 sm:px-4" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus />
                                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                                </div>

                                <!-- NISN -->
                                <div>
                                    <x-input-label for="nisn" :value="__('NISN')" />
                                    <x-text-input id="nisn" class="block mt-1 w-full text-sm sm:text-base py-2 px-3 sm:px-4" type="text" name="nisn" :value="old('nisn')" />
                                    <x-input-error :messages="$errors->get('nisn')" class="mt-2" />
                                </div>

                                <!-- Jenis Kelamin -->
                                <div>
                                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base py-2 px-3 sm:px-4">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                                </div>

                                <!-- Tempat Lahir -->
                                <div>
                                    <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                    <x-text-input id="tempat_lahir" class="block mt-1 w-full text-sm sm:text-base py-2 px-3 sm:px-4" type="text" name="tempat_lahir" :value="old('tempat_lahir')" />
                                    <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="tanggal_lahir" class="block mt-1 w-full text-sm sm:text-base py-2 px-3 sm:px-4" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" />
                                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                                </div>

                                <!-- Alamat -->
                                <div class="md:col-span-2">
                                    <x-input-label for="alamat" :value="__('Alamat')" />
                                    <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm sm:text-base px-3 sm:px-4 py-2">{{ old('alamat') }}</textarea>
                                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Form Buttons -->
                            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 sm:gap-4 mt-8 pt-6 border-t">
                                <a href="{{ route('guru.siswa.index') }}" class="inline-flex justify-center w-full sm:w-auto underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 px-4 py-2">
                                    Batal
                                </a>
                                <x-primary-button class="w-full sm:w-auto justify-center" id="submit-btn" type="submit">
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toast notification function
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toast-container');
            
            // Tentukan warna berdasarkan tipe
            let bgColor, borderColor, textColor, icon;
            switch(type) {
                case 'success':
                    bgColor = 'bg-green-50';
                    borderColor = 'border-green-200';
                    textColor = 'text-green-800';
                    icon = '✅';
                    break;
                case 'error':
                    bgColor = 'bg-red-50';
                    borderColor = 'border-red-200';
                    textColor = 'text-red-800';
                    icon = '❌';
                    break;
                case 'warning':
                    bgColor = 'bg-yellow-50';
                    borderColor = 'border-yellow-200';
                    textColor = 'text-yellow-800';
                    icon = '⚠️';
                    break;
                default:
                    bgColor = 'bg-blue-50';
                    borderColor = 'border-blue-200';
                    textColor = 'text-blue-800';
                    icon = 'ℹ️';
            }

            // Buat elemen toast
            const toast = document.createElement('div');
            toast.className = `${bgColor} border ${borderColor} rounded-lg p-4 mb-3 shadow-md max-w-md animate-slideIn`;
            toast.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <span class="text-lg">${icon}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium ${textColor}">
                            ${message}
                        </p>
                    </div>
                    <button class="ml-3 text-gray-500 hover:text-gray-700" onclick="this.parentElement.parentElement.remove()">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Auto remove setelah 5 detik
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Handle form submission dengan AJAX
        document.getElementById('siswa-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = document.getElementById('submit-btn');
            const originalBtnText = submitBtn.innerText;
            
            // Disable button dan show loading
            submitBtn.disabled = true;
            submitBtn.innerText = 'Menyimpan...';
            
            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Success
                    showToast(data.message, 'success');
                    
                    // Redirect setelah 2 detik
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else if (response.status === 422) {
                    // Quota error atau validation error
                    showToast(data.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalBtnText;
                } else {
                    // Other error
                    showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalBtnText;
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerText = originalBtnText;
            }
        });
    </script>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</x-app-layout>
