<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->get('app_name')?->value ?? 'E-Rapor IGRA' }} - Sistem Rapor Digital Raudhatul Athfal</title>
    @if ($settings->get('app_favicon')?->value)
        <link rel="icon" href="{{ asset('storage/' . $settings->get('app_favicon')->value) }}" type="image/png">
    @else
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='75' font-size='75'>📚</text></svg>">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; }
        
        @keyframes float { 
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .float-animation { animation: float 4s ease-in-out infinite; }
        .slide-in-right { animation: slideInRight 0.8s ease-out; }
        .slide-in-left { animation: slideInLeft 0.8s ease-out; }
        .fade-in { animation: fadeIn 1s ease-out; }
        
        .gradient-blue-purple { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-purple-pink {
            background: linear-gradient(135deg, #764ba2 0%, #f093fb 100%);
        }
        
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .feature-card:hover::before { left: 100%; }
        .feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        
        .section-divider {
            position: relative;
            margin: 4rem 0;
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">
    <!-- Header/Navigation -->
    <header class="sticky top-0 z-50 bg-white shadow-md backdrop-blur-md bg-opacity-95">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        @if ($settings->get('app_logo')?->value)
                            <img src="{{ asset('storage/' . $settings->get('app_logo')->value) }}" alt="Logo" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <!-- Fallback: IGRA Logo SVG -->
                            <svg viewBox="0 0 100 100" class="w-10 h-10">
                                <defs>
                                    <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                <circle cx="50" cy="50" r="48" fill="url(#logoGradient)" opacity="0.1"/>
                                <circle cx="50" cy="50" r="40" fill="none" stroke="url(#logoGradient)" stroke-width="2"/>
                                <circle cx="30" cy="40" r="6" fill="#667eea"/>
                                <circle cx="50" cy="35" r="7" fill="#764ba2"/>
                                <circle cx="70" cy="40" r="6" fill="#667eea"/>
                                <path d="M36 42 L44 37" stroke="#764ba2" stroke-width="1.5" fill="none"/>
                                <path d="M64 37 L56 42" stroke="#764ba2" stroke-width="1.5" fill="none"/>
                                <path d="M50 55 Q40 60 40 68 Q40 75 50 82 Q60 75 60 68 Q60 60 50 55" fill="#f093fb" opacity="0.7"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl font-bold gradient-blue-purple bg-clip-text text-transparent">{{ $settings->get('app_name')?->value ?? 'E-Rapor IGRA SUMUT' }}</h1>
                        <p class="text-xs text-gray-500">{{ $settings->get('app_subtitle')?->value ?? 'Pendidikan Anak Usia Dini' }}</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-gray-700 hover:text-indigo-600 transition text-sm font-medium">Fitur</a>
                    <a href="#manfaat" class="text-gray-700 hover:text-indigo-600 transition text-sm font-medium">Manfaat</a>
                    <a href="#tentang" class="text-gray-700 hover:text-indigo-600 transition text-sm font-medium">Tentang</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-2 md:space-x-3">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm px-4 py-2 rounded-lg hover:bg-indigo-50 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-gradient text-white font-medium text-sm px-4 py-2 rounded-lg shadow-md">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="gradient-blue-purple text-white py-20 md:py-28">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="slide-in-left">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                        {{ $settings->get('hero_title')?->value ?? 'Sistem Rapor Digital untuk' }}<span class="text-pink-300"> Raudhatul Athfal</span>
                    </h2>
                    <p class="text-lg md:text-xl mb-6 opacity-95">
                        {{ $settings->get('hero_subtitle')?->value ?? 'Kelola perkembangan siswa dengan kurikulum berbasis cinta yang komprehensif dan mudah digunakan' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-bold text-center hover:shadow-lg transform hover:scale-105 transition">
                            Mulai Sekarang
                        </a>
                        <button onclick="document.getElementById('fitur').scrollIntoView({behavior:'smooth'})" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:bg-opacity-10 transition">
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                    <div class="flex gap-8 mt-10 text-sm">
                        <div>
                            <p class="text-2xl font-bold">{{ $totalGuru }}+</p>
                            <p class="opacity-80">Guru Aktif</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">{{ $totalSiswa }}+</p>
                            <p class="opacity-80">Siswa Terdaftar</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">{{ $totalSekolah }}+</p>
                            <p class="opacity-80">Sekolah IGRA</p>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="slide-in-right flex justify-center">
                    @if ($settings->get('hero_image')?->value)
                        <img src="{{ asset('storage/' . $settings->get('hero_image')->value) }}" 
                             alt="Hero Image" 
                             class="w-full max-w-md rounded-xl shadow-lg float-animation">
                    @else
                        <div class="float-animation">
                            <svg viewBox="0 0 300 300" class="w-72 h-72">
                                <!-- Gradient definitions -->
                                <defs>
                                    <linearGradient id="heroGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#f093fb;stop-opacity:0.2" />
                                        <stop offset="100%" style="stop-color:#f5576c;stop-opacity:0.2" />
                                    </linearGradient>
                                </defs>
                                <!-- Background circles -->
                                <circle cx="150" cy="150" r="140" fill="url(#heroGrad1)"/>
                                <circle cx="150" cy="150" r="120" fill="white" opacity="0.05"/>
                                <!-- Document/Report -->
                                <rect x="80" y="60" width="140" height="180" rx="10" fill="white" stroke="#667eea" stroke-width="2"/>
                                <!-- Lines on document -->
                                <line x1="95" y1="85" x2="205" y2="85" stroke="#667eea" stroke-width="2"/>
                                <line x1="95" y1="105" x2="205" y2="105" stroke="#764ba2" stroke-width="1.5" opacity="0.7"/>
                                <line x1="95" y1="125" x2="185" y2="125" stroke="#764ba2" stroke-width="1.5" opacity="0.7"/>
                                <line x1="95" y1="145" x2="205" y2="145" stroke="#764ba2" stroke-width="1.5" opacity="0.7"/>
                                <line x1="95" y1="165" x2="195" y2="165" stroke="#764ba2" stroke-width="1.5" opacity="0.7"/>
                                <line x1="95" y1="185" x2="205" y2="185" stroke="#764ba2" stroke-width="1.5" opacity="0.7"/>
                                <!-- Heart badge -->
                                <circle cx="220" cy="60" r="20" fill="#f093fb"/>
                                <path d="M220 52 Q214 50 212 56 Q212 62 220 68 Q228 62 228 56 Q226 50 220 52" fill="white"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 md:py-28 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">{{ $settings->get('features_title')?->value ?? 'Fitur Unggulan' }}</h2>
                <p class="text-lg text-gray-600">{{ $settings->get('features_subtitle')?->value ?? 'Semua yang Anda butuhkan untuk mengelola rapor siswa' }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        📝
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Penilaian Digital</h3>
                    <p class="text-sm text-gray-600 text-center">Input nilai siswa dengan mudah melalui formulir digital yang user-friendly</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        📊
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Laporan Komprehensif</h3>
                    <p class="text-sm text-gray-600 text-center">Rapor lengkap sesuai kurikulum berbasis cinta untuk raudhatul athfal</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        🎓
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Manajemen Siswa</h3>
                    <p class="text-sm text-gray-600 text-center">Kelola data siswa, kelas, dan informasi akademik dengan terstruktur</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        🔒
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Keamanan Tinggi</h3>
                    <p class="text-sm text-gray-600 text-center">Data tersimpan aman dengan enkripsi dan sistem backup terpercaya</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        📱
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Responsif</h3>
                    <p class="text-sm text-gray-600 text-center">Akses dari desktop, tablet, atau smartphone kapan saja</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        ⚡
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Performa Cepat</h3>
                    <p class="text-sm text-gray-600 text-center">Aplikasi ringan dan responsif dengan loading time minimal</p>
                </div>

                <!-- Feature 7 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        📤
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Export/Import</h3>
                    <p class="text-sm text-gray-600 text-center">Ekspor rapor ke PDF atau import data massal dengan Excel</p>
                </div>

                <!-- Feature 8 -->
                <div class="feature-card bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <div class="bg-gradient-blue-purple w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto text-2xl">
                        👥
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Multi-User</h3>
                    <p class="text-sm text-gray-600 text-center">Dukungan untuk guru, admin sekolah, dan admin provinsi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="manfaat" class="py-20 md:py-28">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-16">{{ $settings->get('benefits_title')?->value ?? 'Mengapa Memilih E-Rapor IGRA?' }}</h2>

                <div class="space-y-6">
                    <!-- Benefit 1 -->
                    <div class="flex gap-6 items-start bg-gradient-to-r from-indigo-50 to-transparent p-6 rounded-xl border border-indigo-100">
                        <div class="text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Kurikulum Berbasis Cinta</h3>
                            <p class="text-gray-600">Dirancang khusus untuk kurikulum Raudhatul Athfal yang menekankan aspek afektif, kognitif, dan psikomotor</p>
                        </div>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="flex gap-6 items-start bg-gradient-to-r from-purple-50 to-transparent p-6 rounded-xl border border-purple-100">
                        <div class="text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Efisiensi Waktu</h3>
                            <p class="text-gray-600">Hemat waktu guru dalam mengisi rapor manual dengan sistem otomatis yang cepat dan akurat</p>
                        </div>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="flex gap-6 items-start bg-gradient-to-r from-pink-50 to-transparent p-6 rounded-xl border border-pink-100">
                        <div class="text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Transparansi Data</h3>
                            <p class="text-gray-600">Admin provinsi dapat memantau data dari semua sekolah dengan dashboard yang informatif</p>
                        </div>
                    </div>

                    <!-- Benefit 4 -->
                    <div class="flex gap-6 items-start bg-gradient-to-r from-indigo-50 to-transparent p-6 rounded-xl border border-indigo-100">
                        <div class="text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Kontrol Akses</h3>
                            <p class="text-gray-600">Sistem otentikasi yang ketat memastikan hanya pengguna yang berwenang yang dapat mengakses data</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About IGRA Section -->
    <section id="tentang" class="gradient-blue-purple text-white py-20 md:py-28">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-8">{{ $settings->get('about_title')?->value ?? 'Tentang IGRA Sumut' }}</h2>
                <p class="text-lg mb-6 opacity-95">
                    {{ $settings->get('about_description')?->value ?? 'Ikatan Guru Raudhatul Athfal (IGRA) Sumut adalah organisasi profesi guru yang berdedikasi meningkatkan kualitas pendidikan anak usia dini di Sumatera Utara.' }}
                </p>
                <p class="text-base opacity-90 mb-8">
                    {{ $settings->get('about_vision')?->value ?? 'Kami berkomitmen untuk memberikan solusi inovatif dalam pendidikan berbasis cinta (Kurikulum Berbasis Cinta) yang mengintegrasikan nilai-nilai spiritual, akademik, dan karakter dalam proses pembelajaran anak.' }}
                </p>

                <div class="grid md:grid-cols-3 gap-6 mt-12">
                    <div class="bg-white bg-opacity-10 backdrop-blur-md p-6 rounded-xl border border-white border-opacity-20">
                        <div class="text-4xl mb-3">🎓</div>
                        <h3 class="text-xl font-bold mb-2">Profesional</h3>
                        <p class="text-sm opacity-90">Meningkatkan kompetensi dan dedikasi guru Raudhatul Athfal</p>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-md p-6 rounded-xl border border-white border-opacity-20">
                        <div class="text-4xl mb-3">💡</div>
                        <h3 class="text-xl font-bold mb-2">Inovatif</h3>
                        <p class="text-sm opacity-90">Solusi digital terdepan untuk pendidikan anak usia dini</p>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-md p-6 rounded-xl border border-white border-opacity-20">
                        <div class="text-4xl mb-3">❤️</div>
                        <h3 class="text-xl font-bold mb-2">Berbasis Cinta</h3>
                        <p class="text-sm opacity-90">Pendidikan penuh kasih sayang untuk perkembangan optimal anak</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gray-50 py-16 md:py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">{{ $settings->get('cta_title')?->value ?? 'Siap Memulai?' }}</h2>
            <p class="text-lg text-gray-600 mb-8">{{ $settings->get('cta_description')?->value ?? 'Daftar sekarang dan mulai kelola rapor siswa Anda dengan lebih efisien' }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-gradient text-white font-bold px-8 py-4 rounded-lg shadow-lg text-center hover:shadow-xl">
                    Buat Akun Baru
                </a>
                <a href="{{ route('login') }}" class="border-2 border-indigo-600 text-indigo-600 font-bold px-8 py-4 rounded-lg hover:bg-indigo-50 transition text-center">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="font-bold text-lg mb-4">E-Rapor IGRA</h3>
                    <p class="text-sm text-gray-400">{{ $settings->get('footer_about')?->value ?? 'Sistem rapor digital untuk Raudhatul Athfal berbasis kurikulum cinta' }}</p>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#fitur" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#manfaat" class="hover:text-white transition">Manfaat</a></li>
                        <li><a href="#tentang" class="hover:text-white transition">Tentang</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Email: {{ $settings->get('footer_email')?->value ?? 'info@igra-sumut.org' }}</li>
                        <li>Phone: {{ $settings->get('footer_phone')?->value ?? '+62 XXX XXXX XXXX' }}</li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Twitter</a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                <p>{{ $settings->get('footer_copyright')?->value ?? '© 2025 E-Rapor IGRA Sumut. Semua hak dilindungi.' }}</p>
                <p class="mt-2">Dikembangkan untuk pendidikan anak usia dini yang lebih baik oleh Ikatan Guru Raudhatul Athfal (IGRA) Sumut</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('section > div, .feature-card').forEach(el => {
            el.style.opacity = '0.8';
            observer.observe(el);
        });
    </script>
</body>
</html>

