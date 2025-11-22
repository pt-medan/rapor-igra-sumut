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

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-slide-down {
            animation: slideDown 0.4s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }

        /* Card hover scale effect */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
        }

        /* Smooth button transitions */
        button, a {
            transition: all 0.2s ease;
        }

        /* Pulse animation for attention-needed alert */
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

        /* Smooth row transitions */
        tbody tr {
            transition: background-color 0.2s ease, opacity 0.2s ease;
        }

        /* Fade out effect for hidden rows */
        tbody tr[style*="display: none"] {
            opacity: 0;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card with Primary CTA -->
            <div class="mb-6 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg shadow-lg p-4 sm:p-6 text-white animate-fade-in-up">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    <!-- Left: Greeting -->
                    <div class="md:col-span-2">
                        <h1 class="text-2xl sm:text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
                        <p class="mt-2 text-sm sm:text-base text-indigo-100">
                            <strong>{{ $kelas->nama_kelompok }}</strong> • 
                            <strong>{{ $sekolah->nama_sekolah }}</strong>
                        </p>
                    </div>
                    
                    <!-- Right: Quick Stats -->
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-white bg-opacity-10 rounded-lg p-2 sm:p-3">
                            <p class="text-xs text-indigo-100">Total Siswa</p>
                            <p class="text-xl sm:text-2xl font-bold">{{ $jumlahSiswa }}</p>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-lg p-2 sm:p-3">
                            <p class="text-xs text-indigo-100">Progress</p>
                            <p class="text-xl sm:text-2xl font-bold">{{ $persentaseDinilai }}%</p>
                        </div>
                    </div>
                </div>
                
                <!-- Primary CTA Section -->
                <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-white border-opacity-20">
                    @if($jumlahBelumDinilai > 0)
                    <div class="mb-3 sm:mb-4 bg-yellow-200 bg-opacity-20 rounded-lg p-2 sm:p-3 border border-yellow-300 border-opacity-30 animate-pulse-subtle">
                        <p class="text-yellow-100 font-semibold text-xs sm:text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>
                                Attention needed: <strong>{{ $jumlahBelumDinilai }}</strong> student{{ $jumlahBelumDinilai > 1 ? 's' : '' }} 
                                still awaiting rating
                            </span>
                        </p>
                    </div>
                    @endif
                    
                    <div class="flex flex-col gap-2 sm:gap-3">
                        @if($jumlahBelumDinilai > 0)
                            <a href="{{ route('guru.rapor.index') }}" 
                               title="Mulai menginputkan nilai rapor untuk siswa ({{ $jumlahBelumDinilai }} siswa belum dinilai)"
                               aria-label="Input Rapor - Mulai menginputkan nilai rapor"
                               class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-opacity-90 transition text-center flex items-center justify-center gap-2 text-sm sm:text-base min-h-[44px] sm:min-h-auto">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span class="truncate">Input Rapor ({{ $jumlahBelumDinilai }})</span>
                            </a>
                        @endif
                        <a href="{{ route('guru.siswa.index') }}" 
                           title="Lihat dan kelola daftar semua siswa di kelas ini"
                           aria-label="Kelola Siswa - Lihat dan kelola daftar siswa"
                           class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-white bg-opacity-20 text-white rounded-lg font-semibold hover:bg-opacity-30 transition text-center flex items-center justify-center gap-2 border border-white text-sm sm:text-base min-h-[44px] sm:min-h-auto">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 11a6 6 0 00-5.86 0m.001-.02a.768.768 0 00-.140.54V14a6 6 0 006 6 6 6 0 006-6v-2.46a.768.768 0 00-.14-.54 6 6 0 00-5.86 0z" />
                            </svg>
                            <span class="hidden sm:inline">Kelola Siswa</span>
                            <span class="sm:hidden">Kelola</span>
                        </a>
                        <a href="{{ route('guru.siswa.create') }}" 
                           title="Tambahkan siswa baru ke dalam kelas Anda"
                           aria-label="Tambah Siswa - Tambahkan siswa baru"
                           class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-white bg-opacity-20 text-white rounded-lg font-semibold hover:bg-opacity-30 transition text-center flex items-center justify-center gap-2 border border-white text-sm sm:text-base min-h-[44px] sm:min-h-auto">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            <span class="hidden sm:inline">Tambah Siswa</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Student Quota Card (if guru has quota) -->
            @if(Auth::user()->guru && Auth::user()->guru->student_quota > 0)
            <div class="mb-6 bg-blue-50 rounded-lg shadow p-4 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-700 font-semibold text-sm mb-1 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                            Kuota Siswa Anda
                        </p>
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-2xl font-bold text-blue-600">{{ $jumlahSiswa }}/{{ Auth::user()->guru->student_quota }}</p>
                                <p class="text-xs text-blue-600">Siswa terdaftar</p>
                            </div>
                            <div class="flex-1 max-w-xs">
                                <div class="w-full bg-gray-300 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition" style="width: {{ ($jumlahSiswa / Auth::user()->guru->student_quota) * 100 }}%"></div>
                                </div>
                            </div>
                            @if($jumlahSiswa >= Auth::user()->guru->student_quota)
                                <div class="text-right">
                                    <p class="text-red-600 font-semibold text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Kuota Penuh
                                    </p>
                                    <p class="text-xs text-gray-600">Hubungi admin untuk penambahan</p>
                                </div>
                            @else
                                <div class="text-right">
                                    <p class="text-green-600 font-semibold text-sm">{{ Auth::user()->guru->student_quota - $jumlahSiswa }}</p>
                                    <p class="text-xs text-gray-600">Sisa kuota</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Primary Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Siswa -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-blue-500 p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Siswa</p>
                            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $jumlahSiswa }}</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Sudah Dinilai -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-green-500 p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Sudah Dinilai</p>
                            <p class="text-4xl font-bold text-green-600 mt-2">{{ $jumlahDinilai }}/{{ $jumlahSiswa }}</p>
                        </div>
                        <svg class="w-12 h-12 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <!-- Progress Bar -->
                    <div class="mt-4 bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full transition" style="width: {{ $persentaseDinilai }}%"></div>
                    </div>
                </div>

                <!-- Belum Dinilai -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-yellow-500 p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Belum Dinilai</p>
                            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $jumlahBelumDinilai }}</p>
                        </div>
                        <svg class="w-12 h-12 text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89a6 6 0 01-8.954-5.387 6 6 0 18.72.102A6 6 0 0113.477 14.89z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Dashboard Analytics Section -->
            <div class="mb-6 bg-white rounded-lg shadow-md overflow-hidden animate-fade-in-up" style="animation-delay: 0.25s;">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                        Analytics Penilaian
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Performance Metrics Grid -->
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
                                    <div class="bg-gradient-to-r from-indigo-400 to-indigo-600 h-3 rounded-full transition" style="width: {{ $jumlahSiswa > 0 ? round(($jumlahDinilai / $jumlahSiswa) * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Evaluation Status Breakdown -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4">
                            <p class="text-sm font-semibold text-gray-700 mb-3">Ringkasan Status</p>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">✓ Dinilai</span>
                                    <span class="font-bold text-green-600">{{ $jumlahDinilai }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">⏳ Belum Dinilai</span>
                                    <span class="font-bold text-yellow-600">{{ $jumlahBelumDinilai }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">📊 Total</span>
                                    <span class="font-bold text-gray-800">{{ $jumlahSiswa }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity Summary -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4">
                            <p class="text-sm font-semibold text-gray-700 mb-3">Aktivitas Terkini</p>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Periode Aktif</span>
                                    <span class="font-bold text-purple-600">{{ $currentTahunAjaran ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Semester</span>
                                    <span class="font-bold text-purple-600">{{ $currentSemester ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Kelas Aktif</span>
                                    <span class="font-bold text-purple-600">{{ $kelas->nama_kelas ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Insights -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <p class="text-sm font-semibold text-blue-900 mb-2">💡 Insights</p>
                        <p class="text-sm text-blue-800">
                            @if($jumlahSiswa > 0)
                                @if(($jumlahDinilai / $jumlahSiswa) >= 0.9)
                                    Excellent! {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% siswa sudah dinilai. Hampir selesai untuk periode ini.
                                @elseif(($jumlahDinilai / $jumlahSiswa) >= 0.7)
                                    Good progress! {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% siswa sudah dinilai. Lanjutkan untuk menyelesaikan sisanya.
                                @elseif(($jumlahDinilai / $jumlahSiswa) >= 0.5)
                                    Halfway there! {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% siswa sudah dinilai. Tingkatkan kecepatan penilaian.
                                @else
                                    Mulai dengan menilai siswa yang belum dinilai. Saat ini baru {{ round(($jumlahDinilai / $jumlahSiswa) * 100) }}% selesai.
                                @endif
                            @else
                                Belum ada siswa di kelas ini. Tambahkan siswa terlebih dahulu.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Period Filter Section - MAKE IT OBVIOUS -->
            <div class="mb-6 bg-white rounded-lg shadow-md p-3 sm:p-4 border-l-4 border-blue-500 animate-slide-down">
                <form method="GET" class="flex flex-col gap-3 sm:gap-4" aria-label="Filter periode penilaian">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <x-dashboard.form-select
                            name="tahun_ajaran"
                            id="tahun-select"
                            label="Tahun Ajaran"
                            title="Pilih tahun ajaran untuk memfilter data"
                            ariaLabel="Pilih tahun ajaran"
                            help="Pilih tahun ajaran untuk menampilkan data yang sesuai"
                            :value="$currentTahunAjaran"
                            :options="array_combine($availableTahunAjaran, $availableTahunAjaran)"
                        />
                        
                        <x-dashboard.form-select
                            name="semester"
                            id="semester-select"
                            label="Semester"
                            title="Pilih semester (Ganjil atau Genap)"
                            ariaLabel="Pilih semester"
                            help="Pilih semester untuk memfilter data penilaian"
                            :value="$currentSemester"
                            :options="['Ganjil' => 'Ganjil', 'Genap' => 'Genap']"
                        />
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 items-stretch sm:items-end">
                        <x-dashboard.button
                            type="submit"
                            title="Terapkan filter untuk menampilkan data sesuai pilihan tahun ajaran dan semester"
                            ariaLabel="Terapkan filter"
                            class="filter-submit-btn"
                        >
                            <svg class="w-4 h-4 filter-icon" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 016 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            <span class="filter-text">Filter</span>
                            <svg class="w-4 h-4 filter-spinner hidden animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Filter
                        </x-dashboard.button>
                        
                        <!-- Show current selection -->
                        @if($currentTahunAjaran || $currentSemester)
                            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 overflow-x-auto">
                                <span class="font-medium whitespace-nowrap">Menampilkan:</span>
                                @if($currentTahunAjaran)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded whitespace-nowrap">
                                        {{ $currentTahunAjaran }}
                                    </span>
                                @endif
                                @if($currentSemester)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded whitespace-nowrap">
                                        {{ $currentSemester }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Consolidated Stats - Only 3 Essential Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-6">
                <!-- Card 1: Belum Dinilai (PRIORITY) -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-yellow-500 p-4 sm:p-6 hover:shadow-lg transition card-hover animate-fade-in-up" style="animation-delay: 0.05s;">
                    <div class="flex items-start sm:items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-gray-600 text-xs sm:text-sm font-medium">Belum Dinilai</p>
                            <p class="text-3xl sm:text-4xl font-bold text-yellow-600 mt-2">{{ $jumlahBelumDinilai }}</p>
                            <p class="text-xs text-gray-500 mt-2">siswa perlu rating</p>
                        </div>
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-yellow-200 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 13a3 3 0 100-6H1v6h4zm15-1a3 3 0 01-3 3h-6v-6h6a3 3 0 013 3z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Quota (if applicable) -->
                @if(Auth::user()->guru && Auth::user()->guru->student_quota > 0)
                <div class="bg-white rounded-lg shadow-md border-l-4 border-purple-500 p-4 sm:p-6 hover:shadow-lg transition card-hover animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Kuota Siswa</p>
                            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $jumlahSiswa }}/{{ Auth::user()->guru->student_quota }}</p>
                            <div class="mt-3 bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full transition" 
                                     style="width: {{ ($jumlahSiswa / Auth::user()->guru->student_quota) * 100 }}%"></div>
                            </div>
                        </div>
                        <svg class="w-12 h-12 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                </div>
                @endif

                <!-- Card 3: Periode -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-gray-500 p-4 sm:p-6 card-hover animate-fade-in-up" style="animation-delay: 0.15s;">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Periode Aktif</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">
                            {{ $currentTahunAjaran ?? 'Belum dipilih' }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            Semester <strong>{{ $currentSemester ?? 'Belum dipilih' }}</strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            @if($recentPenilaians->isNotEmpty())
            <x-dashboard.card
                title="Aktivitas Terbaru"
                icon="<path fill-rule='evenodd' d='M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z' clip-rule='evenodd' />"
                animated
                delay="0.2s"
                class="mb-6"
            >
                <div class="max-h-64 overflow-y-auto">
                    @foreach($recentPenilaians->take(5) as $penilaian)
                        <x-dashboard.activity-item
                            :nama="$penilaian->siswa->nama_lengkap"
                            :tanggal="$penilaian->updated_at->format('d M Y H:i')"
                            :href="route('guru.penilaian.edit', $penilaian)"
                        />
                    @endforeach
                </div>
            </x-dashboard.card>
            @endif

            <!-- Students List (Simplified) -->
            <form action="{{ route('guru.export.rapor.massal') }}" method="POST" id="bulk-export-form" aria-label="Formulir ekspor dan kelola daftar siswa">
                @csrf
                <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fade-in-up" style="animation-delay: 0.25s;">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center" id="siswa-list">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10.907A8.002 8.002 0 005.5 14c.846 0 1.659-.135 2.5-.387V4.804zM9 15.977V4.804m0 0a7.967 7.967 0 013.5-.804c1.255 0 2.443.29 3.5.804v10.907A8.002 8.002 0 0014.5 14c-.846 0-1.659.135-2.5.387m0-11.974V4.804" />
                                </svg>
                                Daftar Siswa
                            </h3>
                        </div>
                        <div class="flex gap-2">
                            @if($penilaians->isNotEmpty())
                                <button type="submit" title="Unduh data siswa yang dipilih dalam format Excel" aria-label="Unduh data siswa yang dipilih" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition flex items-center gap-2 download-submit-btn">
                                    <svg class="w-4 h-4 download-icon" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="download-text">Download Massal</span>
                                    <svg class="w-4 h-4 download-spinner hidden animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </button>
                                <a href="{{ route('guru.export.rapor.kelas', ['kelompok_kelas' => $kelas, 'tahun_ajaran' => $currentTahunAjaran, 'semester' => $currentSemester]) }}" target="_blank" title="Cetak semua data siswa dalam format PDF (membuka tab baru)" aria-label="Cetak semua data siswa" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M5 4v2h6V4H5zm6 10H5v2h6v-2zm3-6v6a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h6a2 2 0 012 2v4zm-2 0V4H5v10h6V8z" />
                                    </svg>
                                    Cetak Semua
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <!-- Export & Stats Summary -->
                        <div class="px-3 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-200">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Total Siswa</p>
                                    <p class="text-2xl font-bold text-blue-600 mt-1" id="total-students">{{ count($siswas) }}</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Sudah Dinilai</p>
                                    <p class="text-2xl font-bold text-green-600 mt-1" id="evaluated-count">{{ $penilaians->count() }}</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Belum Dinilai</p>
                                    <p class="text-2xl font-bold text-yellow-600 mt-1" id="pending-count">{{ count($siswas) - $penilaians->count() }}</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Tingkat Selesai</p>
                                    <p class="text-2xl font-bold text-purple-600 mt-1" id="completion-rate">
                                        @if(count($siswas) > 0)
                                            {{ round(($penilaians->count() / count($siswas)) * 100) }}%
                                        @else
                                            0%
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Search Box for Students Table -->
                        <div class="px-3 sm:px-6 py-3 sm:py-4 bg-white border-b border-gray-200">
                            <div class="flex flex-col gap-3">
                                <!-- Main Search Row -->
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                    <div class="flex-1 relative min-w-0">
                                        <label for="student-search" class="sr-only">Cari siswa berdasarkan nama atau NISN</label>
                                        <input 
                                            type="text" 
                                            id="student-search" 
                                            placeholder="Cari siswa..." 
                                            title="Ketik nama siswa atau NISN untuk mencari"
                                            aria-label="Cari siswa berdasarkan nama atau NISN"
                                            aria-describedby="search-help"
                                            class="w-full px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 min-h-[44px] sm:min-h-auto"
                                        >
                                        <svg class="absolute right-3 top-2.5 sm:top-3 w-5 h-5 text-gray-400 pointer-events-none flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <small id="search-help" class="text-gray-500 text-xs mt-1 hidden">Ketik nama lengkap atau NISN untuk memfilter daftar siswa</small>
                                    </div>
                                    <button 
                                        id="clear-search" 
                                        type="button"
                                        title="Hapus pencarian dan tampilkan semua siswa"
                                        aria-label="Bersihkan pencarian"
                                        class="px-3 sm:px-4 py-2 text-sm font-semibold bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition whitespace-nowrap min-h-[44px] sm:min-h-auto"
                                    >
                                        Bersihkan
                                    </button>
                                    <div class="py-2 px-3 bg-gray-100 rounded-lg text-xs sm:text-sm text-gray-600 font-medium whitespace-nowrap" aria-live="polite" role="status">
                                        <span class="hidden sm:inline">Hasil: </span><span id="search-count">{{ count($siswas) }}</span>
                                    </div>
                                </div>

                                <!-- Advanced Filter Row -->
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 items-stretch sm:items-center">
                                    <label for="status-filter" class="text-xs font-semibold text-gray-600 py-2 sm:py-0 whitespace-nowrap">Filter Status:</label>
                                    <select 
                                        id="status-filter"
                                        title="Pilih status penilaian untuk memfilter"
                                        aria-label="Filter berdasarkan status penilaian"
                                        class="flex-1 px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 min-h-[44px] sm:min-h-auto"
                                    >
                                        <option value="">Semua Status</option>
                                        <option value="completed">Sudah Dinilai</option>
                                        <option value="pending">Belum Dinilai</option>
                                    </select>
                                    
                                    <button 
                                        id="reset-filters"
                                        type="button"
                                        title="Reset semua filter ke kondisi awal"
                                        aria-label="Reset semua filter"
                                        class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition whitespace-nowrap min-h-[44px] sm:min-h-auto"
                                    >
                                        Reset Filter
                                    </button>
                                </div>
                            </div>
                        </div>

                        <table class="w-full text-sm" role="table" aria-label="Daftar siswa dan status penilaian">
                            <thead class="bg-gray-100 border-b border-gray-200">
                                <tr role="row">
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700" scope="col">
                                        <input 
                                            type="checkbox" 
                                            id="select-all" 
                                            title="Pilih atau lepas pilihan semua siswa"
                                            aria-label="Pilih semua siswa di tabel"
                                            class="rounded"
                                        >
                                    </th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700" scope="col">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700" scope="col">NISN</th>
                                    <th class="px-6 py-3 text-center font-semibold text-gray-700" scope="col">Status Penilaian</th>
                                    <th class="px-6 py-3 text-right font-semibold text-gray-700" scope="col">Aksi</th>
                                    <th class="px-6 py-3 text-center font-semibold text-gray-700" scope="col"><span class="sr-only">Ekspansi detail</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="students-table-body">
                                @forelse ($siswas->take(10) as $siswa)
                                    @php
                                        $penilaian = $penilaians->get($siswa->id);
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition student-row" data-name="{{ strtolower($siswa->nama_lengkap) }}" data-nisn="{{ strtolower($siswa->nisn ?? '') }}" data-student-id="{{ $siswa->id }}">
                                        <td class="px-6 py-4">
                                            @if ($penilaian)
                                                <input type="checkbox" name="penilaian_ids[]" value="{{ $penilaian->id }}" class="row-checkbox rounded">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $siswa->nisn ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($penilaian)
                                                <x-dashboard.status-badge status="completed" />
                                            @else
                                                <x-dashboard.status-badge status="pending" />
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex gap-2 justify-end">
                                                @if ($penilaian)
                                                    <a href="{{ route('guru.penilaian.edit', $penilaian) }}" title="Edit penilaian untuk {{ $siswa->nama_lengkap }}" aria-label="Edit penilaian - {{ $siswa->nama_lengkap }}" class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold hover:bg-blue-200 transition">
                                                        Edit
                                                    </a>
                                                @else
                                                    <a href="{{ route('guru.siswa.penilaian.create', $siswa) }}" title="Buat rapor baru untuk {{ $siswa->nama_lengkap }}" aria-label="Buat Rapor - {{ $siswa->nama_lengkap }}" class="px-2 py-1 bg-green-600 text-white rounded text-xs font-semibold hover:bg-green-700 transition">
                                                        Buat Rapor
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button 
                                                type="button"
                                                class="expand-toggle p-2 hover:bg-gray-200 rounded transition"
                                                title="Perluas untuk melihat detail siswa"
                                                aria-label="Perluas detail untuk {{ $siswa->nama_lengkap }}"
                                                aria-expanded="false"
                                                data-student-id="{{ $siswa->id }}"
                                            >
                                                <svg class="w-4 h-4 transition-transform expand-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Expandable Detail Row -->
                                    <tr class="student-detail-row hidden" data-student-id="{{ $siswa->id }}">
                                        <td colspan="6" class="px-6 py-4 bg-gray-50">
                                            <div class="detail-content space-y-4 max-h-0 overflow-hidden transition-all duration-300">
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Informasi Pribadi</p>
                                                        <div class="space-y-2 text-sm">
                                                            <p><strong>Nama:</strong> {{ $siswa->nama_lengkap }}</p>
                                                            <p><strong>NISN:</strong> {{ $siswa->nisn ?? 'Tidak ada' }}</p>
                                                            <p><strong>Email:</strong> {{ $siswa->user->email ?? 'Tidak ada' }}</p>
                                                        </div>
                                                    </div>
                                                    @if($penilaian)
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Data Penilaian</p>
                                                        <div class="space-y-2 text-sm">
                                                            <p><strong>Terakhir Diubah:</strong> {{ $penilaian->updated_at->format('d M Y H:i') }}</p>
                                                            <p><strong>Status:</strong> <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">Dinilai</span></p>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Status Penilaian</p>
                                                        <div class="space-y-2 text-sm">
                                                            <p class="text-yellow-700"><strong>⚠️ Belum ada penilaian untuk siswa ini</strong></p>
                                                            <p>Silakan buat rapor untuk melanjutkan</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr data-empty-state="true">
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <x-dashboard.empty-state
                                                title="Belum ada siswa di kelas ini"
                                                description="Mulai dengan menambahkan siswa ke kelas Anda"
                                                :actions="[
                                                    [
                                                        'label' => 'Tambah Siswa Baru',
                                                        'href' => route('guru.siswa.create'),
                                                        'variant' => 'green',
                                                        'icon' => '<path fill-rule=\"evenodd\" d=\"M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z\" clip-rule=\"evenodd\" />'
                                                    ],
                                                    route('guru.siswa.import') ? [
                                                        'label' => 'Import dari File',
                                                        'href' => route('guru.siswa.import'),
                                                        'variant' => 'blue',
                                                        'icon' => '<path fill-rule=\"evenodd\" d=\"M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z\" clip-rule=\"evenodd\" />'
                                                    ] : null
                                                ]"
                                            />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($siswas->count() > 10)
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Showing <strong class="font-semibold">{{ min(10, $siswas->count()) }}</strong> 
                            of <strong class="font-semibold">{{ $siswas->count() }}</strong> students
                            @if($siswas->count() > 1)
                                ({{ round(10 / $siswas->count() * 100) }}%)
                            @endif
                        </div>
                        
                        <a href="{{ route('guru.siswa.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center gap-1">
                            Lihat semua siswa
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </form>

            <script>
                // Select-all checkbox functionality
                document.getElementById('select-all')?.addEventListener('change', function(event) {
                    document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
                        checkbox.checked = event.target.checked;
                    });
                });

                // Student search/filter functionality with advanced filtering
                const searchInput = document.getElementById('student-search');
                const clearButton = document.getElementById('clear-search');
                const statusFilter = document.getElementById('status-filter');
                const resetButton = document.getElementById('reset-filters');
                const studentRows = document.querySelectorAll('.student-row');
                const searchCountSpan = document.getElementById('search-count');

                function filterStudents() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const statusFilterValue = statusFilter?.value || '';
                    let visibleCount = 0;

                    studentRows.forEach(function(row) {
                        const name = row.getAttribute('data-name');
                        const nisn = row.getAttribute('data-nisn');
                        
                        // Get status from row (check if "Dinilai" span is visible)
                        const statusBadge = row.querySelector('[aria-label*="Status:"]');
                        const isCompleted = statusBadge && statusBadge.getAttribute('aria-label').includes('Dinilai');
                        const rowStatus = isCompleted ? 'completed' : 'pending';

                        // Check search term match
                        const searchMatch = searchTerm === '' || name.includes(searchTerm) || nisn.includes(searchTerm);
                        
                        // Check status filter match
                        const statusMatch = statusFilterValue === '' || rowStatus === statusFilterValue;

                        // Show row if both filters match
                        if (searchMatch && statusMatch) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update result count
                    searchCountSpan.textContent = visibleCount;

                    // Show/hide empty state if no results
                    const emptyState = document.querySelector('[data-empty-state="true"]');
                    if (emptyState) {
                        emptyState.style.display = visibleCount === 0 ? '' : 'none';
                    }
                }

                // Add event listeners
                if (searchInput) {
                    searchInput.addEventListener('keyup', filterStudents);
                    searchInput.addEventListener('change', filterStudents);
                }

                if (statusFilter) {
                    statusFilter.addEventListener('change', filterStudents);
                }

                if (clearButton) {
                    clearButton.addEventListener('click', function() {
                        searchInput.value = '';
                        filterStudents();
                        searchInput.focus();
                    });
                }

                if (resetButton) {
                    resetButton.addEventListener('click', function() {
                        searchInput.value = '';
                        statusFilter.value = '';
                        filterStudents();
                        searchInput.focus();
                    });
                }

                // Button loading states functionality
                function setupLoadingState(button, textElement, iconElement, spinnerElement) {
                    const form = button.closest('form');
                    
                    if (form) {
                        form.addEventListener('submit', function() {
                            button.disabled = true;
                            textElement.classList.add('hidden');
                            iconElement.classList.add('hidden');
                            spinnerElement.classList.remove('hidden');
                            
                            // Fallback timeout (5 seconds) to re-enable button
                            const timeout = setTimeout(function() {
                                button.disabled = false;
                                textElement.classList.remove('hidden');
                                iconElement.classList.remove('hidden');
                                spinnerElement.classList.add('hidden');
                            }, 5000);
                            
                            // Clear timeout if form completes normally
                            form.addEventListener('success', function() {
                                clearTimeout(timeout);
                            });
                        });
                    }
                }

                // Initialize loading states for Filter button
                const filterBtn = document.querySelector('.filter-submit-btn');
                if (filterBtn) {
                    const filterText = filterBtn.querySelector('.filter-text');
                    const filterIcon = filterBtn.querySelector('.filter-icon');
                    const filterSpinner = filterBtn.querySelector('.filter-spinner');
                    setupLoadingState(filterBtn, filterText, filterIcon, filterSpinner);
                }

                // Initialize loading states for Download button
                const downloadBtn = document.querySelector('.download-submit-btn');
                if (downloadBtn) {
                    const downloadText = downloadBtn.querySelector('.download-text');
                    const downloadIcon = downloadBtn.querySelector('.download-icon');
                    const downloadSpinner = downloadBtn.querySelector('.download-spinner');
                    setupLoadingState(downloadBtn, downloadText, downloadIcon, downloadSpinner);
                }

                // Expandable student details functionality
                const expandButtons = document.querySelectorAll('.expand-toggle');
                expandButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        const studentId = this.getAttribute('data-student-id');
                        const detailRow = document.querySelector(`.student-detail-row[data-student-id="${studentId}"]`);
                        const icon = this.querySelector('.expand-icon');
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';

                        // Toggle detail row visibility
                        if (isExpanded) {
                            // Collapse
                            detailRow.classList.add('hidden');
                            const content = detailRow.querySelector('.detail-content');
                            content.style.maxHeight = '0';
                            this.setAttribute('aria-expanded', 'false');
                            icon.style.transform = 'rotate(0deg)';
                        } else {
                            // Expand
                            detailRow.classList.remove('hidden');
                            const content = detailRow.querySelector('.detail-content');
                            content.style.maxHeight = content.scrollHeight + 'px';
                            this.setAttribute('aria-expanded', 'true');
                            icon.style.transform = 'rotate(180deg)';
                        }
                    });
                });

                // Update detail row visibility when filtering
                function updateDetailRows() {
                    const allDetailRows = document.querySelectorAll('.student-detail-row');
                    allDetailRows.forEach(function(row) {
                        const studentId = row.getAttribute('data-student-id');
                        const studentRow = document.querySelector(`.student-row[data-student-id="${studentId}"]`);
                        if (studentRow && studentRow.style.display === 'none') {
                            row.style.display = 'none';
                        } else if (studentRow) {
                            // Keep detail row visibility based on expanded state
                            const button = studentRow.querySelector('.expand-toggle');
                            if (button && button.getAttribute('aria-expanded') === 'true') {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                }

                // Hook into existing filter function
                const originalFilterStudents = filterStudents;
                window.filterStudents = function() {
                    originalFilterStudents();
                    updateDetailRows();
                };
            </script>

        </div>
    </div>
</x-app-layout>