<x-app-layout>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-slide-down {
            animation: slideDown 0.4s ease-out;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        @keyframes pulse-subtle {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        .animate-pulse-subtle {
            animation: pulse-subtle 3s ease-in-out infinite;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Card with Primary Actions -->
            <div class="mb-6 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg shadow-lg p-6 text-white animate-fade-in-up">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <!-- Left: Greeting & Stats -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                        <p class="text-lg text-indigo-100 mb-4">
                            <strong>{{ $kelas->nama_kelompok }}</strong> • 
                            <strong>{{ $sekolah->nama_sekolah }}</strong>
                        </p>
                        
                        <!-- Quick Stats -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                <p class="text-xs text-indigo-100 mb-1">Total Siswa</p>
                                <p class="text-2xl font-bold">{{ $jumlahSiswa }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                <p class="text-xs text-indigo-100 mb-1">Sudah Dinilai</p>
                                <p class="text-2xl font-bold text-green-300">{{ $jumlahDinilai }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                <p class="text-xs text-indigo-100 mb-1">Belum Dinilai</p>
                                <p class="text-2xl font-bold text-yellow-300">{{ $jumlahBelumDinilai }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                <p class="text-xs text-indigo-100 mb-1">Progress</p>
                                <p class="text-2xl font-bold text-cyan-300">{{ $persentaseDinilai }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Primary Action Buttons -->
                <div class="mt-6 pt-6 border-t border-white border-opacity-20">
                    @if($jumlahBelumDinilai > 0)
                    <div class="mb-4 bg-yellow-200 bg-opacity-20 rounded-lg p-3 border border-yellow-300 border-opacity-30 animate-pulse-subtle">
                        <p class="text-yellow-100 font-semibold text-sm flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>
                                ⚠️ Perhatian: <strong>{{ $jumlahBelumDinilai }}</strong> siswa masih menunggu penilaian
                            </span>
                        </p>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @if($jumlahBelumDinilai > 0)
                        <a href="{{ route('guru.rapor.index') }}" 
                           class="px-6 py-4 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-opacity-90 transition text-center flex items-center justify-center gap-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Input Rapor ({{ $jumlahBelumDinilai }})</span>
                        </a>
                        @endif
                        
                        <a href="{{ route('guru.siswa.index') }}" 
                           class="px-6 py-4 bg-white bg-opacity-20 text-white rounded-lg font-semibold hover:bg-opacity-30 transition text-center flex items-center justify-center gap-2 border border-white backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 11a6 6 0 00-5.86 0m.001-.02a.768.768 0 00-.140.54V14a6 6 0 006 6 6 6 0 006-6v-2.46a.768.768 0 00-.14-.54 6 6 0 00-5.86 0z" />
                            </svg>
                            Kelola Siswa
                        </a>
                        
                        <a href="{{ route('guru.siswa.create') }}" 
                           class="px-6 py-4 bg-green-500 bg-opacity-90 text-white rounded-lg font-semibold hover:bg-green-600 transition text-center flex items-center justify-center gap-2 shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Siswa
                        </a>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout: Main Content + Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Content (Left Column) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Essential Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 animate-fade-in-up" style="animation-delay: 0.1s;">
                        <!-- Card 1: Belum Dinilai (Priority) -->
                        <div class="bg-white rounded-lg shadow-md border-l-4 border-yellow-500 p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm font-medium">Belum Dinilai</p>
                                    <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $jumlahBelumDinilai }}</p>
                                    <p class="text-xs text-gray-500 mt-2">siswa perlu rating</p>
                                </div>
                                <svg class="w-12 h-12 text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card 2: Quota -->
                        @if(Auth::user()->guru && Auth::user()->guru->student_quota > 0)
                        <div class="bg-white rounded-lg shadow-md border-l-4 border-purple-500 p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div class="w-full">
                                    <p class="text-gray-600 text-sm font-medium mb-2">Kuota Siswa</p>
                                    <p class="text-3xl font-bold text-purple-600">{{ $jumlahSiswa }}<span class="text-lg text-gray-400">/{{ Auth::user()->guru->student_quota }}</span></p>
                                    <div class="mt-3 bg-gray-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full transition" 
                                             style="width: {{ ($jumlahSiswa / Auth::user()->guru->student_quota) * 100 }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ Auth::user()->guru->student_quota - $jumlahSiswa }} sisa kuota
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Card 3: Completion Rate -->
                        <div class="bg-white rounded-lg shadow-md border-l-4 border-green-500 p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div class="w-full">
                                    <p class="text-gray-600 text-sm font-medium mb-2">Tingkat Selesai</p>
                                    <p class="text-3xl font-bold text-green-600">{{ $persentaseDinilai }}%</p>
                                    <div class="mt-3 bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full transition" 
                                             style="width: {{ $persentaseDinilai }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ $jumlahDinilai }} dari {{ $jumlahSiswa }} dinilai
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Summary (Collapsible) -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
                        <button type="button" 
                                class="w-full px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center hover:bg-gray-100 transition"
                                onclick="toggleSection('analytics')">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                </svg>
                                Analytics Penilaian
                            </h3>
                            <svg class="w-5 h-5 transition-transform" id="analytics-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div id="analytics-section" class="p-6 space-y-6">
                            <!-- Performance Metrics -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Completion Trend -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4">
                                    <p class="text-sm font-semibold text-gray-700 mb-3">Tingkat Penyelesaian</p>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Periode Saat Ini</span>
                                            <span class="text-2xl font-bold text-indigo-600">
                                                @if($jumlahSiswa > 0)
                                                    {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}%
                                                @else
                                                    0%
                                                @endif
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="bg-gradient-to-r from-indigo-400 to-indigo-600 h-3 rounded-full transition" 
                                                 style="width: {{ $jumlahSiswa > 0 ? round(($jumlahDinilai / $jumlahSiswa) * 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Breakdown -->
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4">
                                    <p class="text-sm font-semibold text-gray-700 mb-3">Ringkasan Status</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">✓ Dinilai</span>
                                            <span class="font-bold text-green-600">{{ $jumlahDinilai }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">⏳ Belum</span>
                                            <span class="font-bold text-yellow-600">{{ $jumlahBelumDinilai }}</span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2 border-t">
                                            <span class="text-gray-600">📊 Total</span>
                                            <span class="font-bold text-gray-800">{{ $jumlahSiswa }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Period Info -->
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4">
                                    <p class="text-sm font-semibold text-gray-700 mb-3">Periode Aktif</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Tahun Ajaran</span>
                                            <span class="font-bold text-purple-600">{{ $currentTahunAjaran ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Semester</span>
                                            <span class="font-bold text-purple-600">{{ $currentSemester ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Kelas</span>
                                            <span class="font-bold text-purple-600">{{ $kelas->nama_kelas ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Insights -->
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                <p class="text-sm font-semibold text-blue-900 mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Insights
                                </p>
                                <p class="text-sm text-blue-800">
                                    @if($jumlahSiswa > 0)
                                        @if(($jumlahDinilai / $jumlahSiswa) >= 0.9)
                                            🎉 Excellent! {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% siswa sudah dinilai. Hampir selesai!
                                        @elseif(($jumlahDinilai / $jumlahSiswa) >= 0.7)
                                            👍 Good progress! {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% siswa sudah dinilai.
                                        @elseif(($jumlahDinilai / $jumlahSiswa) >= 0.5)
                                            💪 Halfway there! {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% siswa sudah dinilai.
                                        @else
                                            🚀 Mari mulai! {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% siswa sudah dinilai.
                                        @endif
                                    @else
                                        ℹ️ Belum ada siswa di kelas ini. Tambahkan siswa terlebih dahulu.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar (Right Column) -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Period Filter (Sticky) -->
                    <div class="bg-white rounded-lg shadow-md p-5 sticky top-6 animate-slide-down">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 016 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filter Periode
                        </h3>
                        
                        <form method="GET" class="space-y-4">
                            <div>
                                <label for="tahun-select" class="block text-xs font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                                <select name="tahun_ajaran" id="tahun-select" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach($availableTahunAjaran as $tahun)
                                        <option value="{{ $tahun }}" @if($currentTahunAjaran == $tahun) selected @endif>{{ $tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="semester-select" class="block text-xs font-medium text-gray-700 mb-1">Semester</label>
                                <select name="semester" id="semester-select" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="Ganjil" @if($currentSemester == 'Ganjil') selected @endif>Ganjil</option>
                                    <option value="Genap" @if($currentSemester == 'Genap') selected @endif>Genap</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 016 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Terapkan Filter
                            </button>
                        </form>

                        <!-- Current Selection -->
                        @if($currentTahunAjaran || $currentSemester)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs font-medium text-gray-600 mb-2">Sedang Tampil:</p>
                            <div class="flex flex-wrap gap-2">
                                @if($currentTahunAjaran)
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded">
                                    {{ $currentTahunAjaran }}
                                </span>
                                @endif
                                @if($currentSemester)
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded">
                                    {{ $currentSemester }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Recent Activities (Collapsible) -->
                    @if($recentPenilaians->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fade-in-up" style="animation-delay: 0.3s;">
                        <button type="button" 
                                class="w-full px-5 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center hover:bg-gray-100 transition"
                                onclick="toggleSection('activities')">
                            <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                Aktivitas Terbaru
                            </h3>
                            <svg class="w-4 h-4 transition-transform" id="activities-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div id="activities-section" class="max-h-80 overflow-y-auto">
                            <div class="divide-y divide-gray-200">
                                @foreach($recentPenilaians->take(10) as $penilaian)
                                <a href="{{ route('guru.penilaian.edit', $penilaian) }}" 
                                   class="block px-5 py-3 hover:bg-gray-50 transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $penilaian->siswa->nama_lengkap }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $penilaian->updated_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Links -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-5 animate-fade-in-up" style="animation-delay: 0.4s;">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                            </svg>
                            Akses Cepat
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('guru.siswa.import.show') }}" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-white hover:text-indigo-600 rounded-lg transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Import Siswa
                            </a>
                            <a href="{{ route('guru.siswa.export') }}" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-white hover:text-indigo-600 rounded-lg transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 3.414V13a1 1 0 11-2 0V3.414L5.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                Export Data
                            </a>
                            <a href="{{ route('guru.sekolah.edit') }}" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-white hover:text-indigo-600 rounded-lg transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                </svg>
                                Profil Sekolah
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        // Toggle collapsible sections
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId + '-section');
            const icon = document.getElementById(sectionId + '-icon');
            
            if (section.style.display === 'none') {
                section.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
            } else {
                section.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Initialize sections as collapsed
        document.addEventListener('DOMContentLoaded', function() {
            // Analytics section starts collapsed
            const analyticsSection = document.getElementById('analytics-section');
            if (analyticsSection) {
                analyticsSection.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
