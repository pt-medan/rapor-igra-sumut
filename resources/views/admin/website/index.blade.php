<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Website') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Admin Website</h1>
                <p class="text-gray-600">Kelola konten halaman depan (Welcome Page) E-Rapor IGRA</p>
            </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <h3 class="text-red-800 font-bold mb-2">Terjadi Kesalahan</h3>
                <ul class="text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6">
                <h2 class="text-2xl font-bold">Pengaturan Konten Halaman Welcome</h2>
                <p class="text-indigo-100 mt-2">Edit informasi yang ditampilkan pada halaman depan aplikasi</p>
            </div>

            <!-- Card Body -->
            <div class="p-8">
                <!-- Quick Stats -->
                <div class="grid md:grid-cols-3 gap-4 mb-8 pb-8 border-b">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg">
                        <p class="text-blue-600 text-sm font-medium">Guru Aktif</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $stats['total_guru'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg">
                        <p class="text-green-600 text-sm font-medium">Siswa Terdaftar</p>
                        <p class="text-3xl font-bold text-green-900">{{ $stats['total_siswa'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-lg">
                        <p class="text-purple-600 text-sm font-medium">Sekolah IGRA</p>
                        <p class="text-3xl font-bold text-purple-900">{{ $stats['total_sekolah'] }}</p>
                    </div>
                </div>

                <!-- Current Settings Display -->
                <div class="space-y-6">
                    <!-- Hero Section -->
                    <div class="border-b pb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"></path>
                            </svg>
                            Hero Section
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 font-medium">TITLE</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $settings->get('hero_title')?->value ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">SUBTITLE</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $settings->get('hero_subtitle')?->value ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Features Section -->
                    <div class="border-b pb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Features Section
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 font-medium">TITLE</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $settings->get('features_title')?->value ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">SUBTITLE</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $settings->get('features_subtitle')?->value ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="border-b pb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            About Section
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 font-medium">TITLE</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $settings->get('about_title')?->value ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">DESCRIPTION</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded line-clamp-2">{{ $settings->get('about_description')?->value ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="pb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948-.684l1.498-4.493a1 1 0 011.502-.684l1.498 4.493a1 1 0 00.948.684H17a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                            </svg>
                            Footer Section
                        </h3>
                        <div class="grid md:grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500 font-medium">EMAIL</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $settings->get('footer_email')?->value ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">PHONE</p>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $settings->get('footer_phone')?->value ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Button -->
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('admin-website.edit') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Konten
                    </a>
                    <a href="{{ route('admin.provinsi.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="text-blue-900 font-bold mb-2">ℹ️ Informasi</h3>
            <ul class="text-blue-800 space-y-1 text-sm">
                <li>• Konten yang Anda atur di sini akan ditampilkan di halaman depan (Welcome Page)</li>
                <li>• Pastikan konten yang ditulis sudah sesuai dengan visi dan misi IGRA Sumut</li>
                <li>• Gunakan kalimat yang jelas dan menarik untuk meningkatkan engagement pengguna</li>
            </ul>
        </div>
    </div>
</x-app-layout>
