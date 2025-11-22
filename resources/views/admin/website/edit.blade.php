<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Website Content') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Edit Konten Website</h1>
                <p class="text-gray-600">Sesuaikan konten halaman depan (Welcome Page) E-Rapor IGRA</p>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6">
                    <h2 class="text-2xl font-bold">Form Edit Konten</h2>
                    <p class="text-indigo-100 mt-2">Perbarui semua bagian dari halaman welcome</p>
                </div>

                <!-- Form -->
                <form action="{{ route('admin-website.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <h3 class="text-red-800 font-bold mb-2">Terjadi Kesalahan</h3>
                            <ul class="text-red-700 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-12">
                        <!-- BRANDING SECTION -->
                        <div class="border-b pb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="text-3xl">🎨</span> Branding & Identity
                            </h3>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- App Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Application Name *</label>
                                    <input type="text" name="app_name" value="{{ $settings->get('app_name')?->value ?? '' }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                           placeholder="E.g. E-Rapor IGRA SUMUT">
                                </div>

                                <!-- App Subtitle -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Application Subtitle *</label>
                                    <input type="text" name="app_subtitle" value="{{ $settings->get('app_subtitle')?->value ?? '' }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                           placeholder="E.g. Pendidikan Anak Usia Dini">
                                </div>

                                <!-- App Logo -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Application Logo</label>
                                    <input type="file" name="app_logo" accept="image/*"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF, WebP (Max: 2MB)</p>
                                    @if ($settings->get('app_logo')?->value)
                                        <div class="mt-3">
                                            <p class="text-xs font-semibold text-gray-700 mb-2">Current Logo:</p>
                                            <img src="{{ asset('storage/' . $settings->get('app_logo')->value) }}" alt="Logo" class="h-20 rounded">
                                        </div>
                                    @endif
                                </div>

                                <!-- App Favicon -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Application Favicon</label>
                                    <input type="file" name="app_favicon" accept="image/*"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF, WebP, ICO (Max: 1MB)</p>
                                    @if ($settings->get('app_favicon')?->value)
                                        <div class="mt-3">
                                            <p class="text-xs font-semibold text-gray-700 mb-2">Current Favicon:</p>
                                            <img src="{{ asset('storage/' . $settings->get('app_favicon')->value) }}" alt="Favicon" class="h-8 rounded">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- HERO SECTION -->
                        <div class="border-b pb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="text-3xl">🎯</span> Hero Section
                            </h3>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Hero Title -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Hero Title *</label>
                                    <input type="text" 
                                           name="hero_title" 
                                           value="{{ $settings->get('hero_title')?->value ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           placeholder="Masukkan judul hero"
                                           required>
                                    <p class="text-gray-500 text-xs mt-1">Judul utama yang terlihat di bagian atas halaman</p>
                                </div>

                                <!-- Hero Image -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Hero Image</label>
                                    <input type="file" 
                                           name="hero_image" 
                                           accept="image/*"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <p class="text-gray-500 text-xs mt-1">JPG, PNG | Max 2MB</p>
                                    @if ($settings->get('hero_image')?->value)
                                        <img src="{{ asset('storage/' . $settings->get('hero_image')->value) }}" 
                                             alt="Hero" class="mt-2 max-w-xs rounded">
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-900 mb-2">Hero Subtitle *</label>
                                <textarea name="hero_subtitle" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                          placeholder="Masukkan subtitle"
                                          required>{{ $settings->get('hero_subtitle')?->value ?? '' }}</textarea>
                                <p class="text-gray-500 text-xs mt-1">Tagline atau deskripsi singkat di bawah judul</p>
                            </div>
                        </div>

                        <!-- FEATURES SECTION -->
                        <div class="border-b pb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="text-3xl">✨</span> Features Section
                            </h3>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Section Title *</label>
                                    <input type="text" 
                                           name="features_title" 
                                           value="{{ $settings->get('features_title')?->value ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Section Subtitle *</label>
                                    <input type="text" 
                                           name="features_subtitle" 
                                           value="{{ $settings->get('features_subtitle')?->value ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- BENEFITS SECTION -->
                        <div class="border-b pb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="text-3xl">💡</span> Benefits Section
                            </h3>

                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Section Title *</label>
                                <input type="text" 
                                       name="benefits_title" 
                                       value="{{ $settings->get('benefits_title')?->value ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       required>
                                <p class="text-gray-500 text-xs mt-1">Judul section manfaat menggunakan E-Rapor</p>
                            </div>
                        </div>

                        <!-- ABOUT SECTION -->
                        <div class="border-b pb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="text-3xl">ℹ️</span> About Section
                            </h3>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Section Title *</label>
                                    <input type="text" 
                                           name="about_title" 
                                           value="{{ $settings->get('about_title')?->value ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-900 mb-2">Description *</label>
                                <textarea name="about_description" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                          required>{{ $settings->get('about_description')?->value ?? '' }}</textarea>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-900 mb-2">Vision/Mission *</label>
                                <textarea name="about_vision" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                          required>{{ $settings->get('about_vision')?->value ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- CTA SECTION -->
                        <div class="border-b pb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="text-3xl">🎯</span> Call-To-Action Section
                            </h3>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Section Title *</label>
                                    <input type="text" 
                                           name="cta_title" 
                                           value="{{ $settings->get('cta_title')?->value ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-900 mb-2">Description *</label>
                                <textarea name="cta_description" 
                                          rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                          required>{{ $settings->get('cta_description')?->value ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- FOOTER SECTION -->
                        <div class="pb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="text-3xl">📞</span> Footer Section
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">About Text *</label>
                                    <textarea name="footer_about" 
                                              rows="2"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                              required>{{ $settings->get('footer_about')?->value ?? '' }}</textarea>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-900 mb-2">Email Contact *</label>
                                        <input type="email" 
                                               name="footer_email" 
                                               value="{{ $settings->get('footer_email')?->value ?? '' }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                               required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-900 mb-2">Phone Contact *</label>
                                        <input type="text" 
                                               name="footer_phone" 
                                               value="{{ $settings->get('footer_phone')?->value ?? '' }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                               required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Copyright Text *</label>
                                    <input type="text" 
                                           name="footer_copyright" 
                                           value="{{ $settings->get('footer_copyright')?->value ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3 pt-8 border-t">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin-website.index') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Help Box -->
            <div class="mt-8 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h3 class="text-yellow-900 font-bold mb-2">💡 Tips Editing</h3>
                <ul class="text-yellow-800 space-y-1 text-sm">
                    <li>• Semua field dengan tanda (*) harus diisi</li>
                    <li>• Gambar hero sebaiknya berformat landscape dengan resolusi minimal 1200x600px</li>
                    <li>• Perubahan akan langsung tampil di halaman depan setelah disimpan</li>
                    <li>• Gunakan kalimat yang jelas, menarik, dan sesuai dengan visi IGRA Sumut</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    textarea {
        resize: vertical;
    }
</style>
