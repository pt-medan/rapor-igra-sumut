<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <!-- Breadcrumb -->
                <nav class="mb-2 text-sm" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-gray-500">
                        <li><a href="{{ route('guru.dashboard') }}" class="hover:text-indigo-600">Dashboard</a></li>
                        <li>/</li>
                        <li class="text-gray-900 font-semibold">Kelola Siswa</li>
                    </ol>
                </nav>
                <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
                    Manajemen Siswa
                </h2>
            </div>
            
            <!-- Quick Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('guru.siswa.create') }}" 
                   class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Siswa
                </a>
                <a href="{{ route('guru.siswa.import.show') }}" 
                   class="inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Import Massal
                </a>
                <a href="{{ route('guru.siswa.export') }}" 
                   class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 3.414V13a1 1 0 11-2 0V3.414L5.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    Export Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($kelas)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    
                    <!-- Header Section -->
                    <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Kelas: <span class="text-indigo-600">{{ $kelas->nama_kelompok }}</span>
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Total <strong>{{ $siswas->total() }}</strong> siswa terdaftar
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Search & Filter Section -->
                    <div class="px-6 py-4 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Search Box -->
                            <div class="md:col-span-5">
                                <label for="student-search" class="block text-xs font-medium text-gray-700 mb-1">Cari Siswa</label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="student-search" 
                                        placeholder="Nama siswa atau NISN..."
                                        class="w-full px-4 py-2 pl-10 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="md:col-span-3">
                                <label for="status-filter" class="block text-xs font-medium text-gray-700 mb-1">Status Rapor</label>
                                <select 
                                    id="status-filter"
                                    class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="has-rapor">Sudah Ada Rapor</option>
                                    <option value="no-rapor">Belum Ada Rapor</option>
                                </select>
                            </div>

                            <!-- Per Page -->
                            <div class="md:col-span-2">
                                <label for="per-page" class="block text-xs font-medium text-gray-700 mb-1">Tampilkan</label>
                                <select 
                                    id="per-page"
                                    class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    onchange="window.location.href = '{{ route('guru.siswa.index') }}?per_page=' + this.value"
                                >
                                    <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            <!-- Reset Button -->
                            <div class="md:col-span-2 flex items-end">
                                <button 
                                    id="reset-filters"
                                    type="button"
                                    class="w-full px-4 py-2 text-sm font-semibold bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                                >
                                    Reset Filter
                                </button>
                            </div>
                        </div>

                        <!-- Search Results Info -->
                        <div class="mt-3 text-sm text-gray-600" role="status" aria-live="polite">
                            Menampilkan <strong id="search-count">{{ $siswas->count() }}</strong> dari <strong>{{ $siswas->total() }}</strong> siswa
                        </div>
                    </div>

                    <!-- Bulk Actions Toolbar (Hidden by default) -->
                    <div id="bulk-actions-toolbar" class="hidden px-6 py-3 bg-blue-50 border-b border-blue-200">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-700">
                                    <span id="bulk-count" class="text-indigo-600">0</span> siswa dipilih
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <!-- Export CSV -->
                                <button 
                                    type="button"
                                    id="bulk-export-csv"
                                    class="px-3 py-2 text-xs sm:text-sm font-semibold bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" />
                                        <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                    </svg>
                                    Export CSV
                                </button>

                                <!-- Export PDF -->
                                <button 
                                    type="button"
                                    id="bulk-export-pdf"
                                    class="px-3 py-2 text-xs sm:text-sm font-semibold bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                    </svg>
                                    Export PDF
                                </button>

                                <!-- Export Excel -->
                                <button 
                                    type="button"
                                    id="bulk-export-excel"
                                    class="px-3 py-2 text-xs sm:text-sm font-semibold bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition flex items-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" />
                                    </svg>
                                    Export Excel
                                </button>

                                <!-- Delete Selected -->
                                <button 
                                    type="button"
                                    id="bulk-delete"
                                    class="px-3 py-2 text-xs sm:text-sm font-semibold bg-red-500 text-white rounded-lg hover:bg-red-600 transition flex items-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Hapus
                                </button>

                                <!-- Clear Selection -->
                                <button 
                                    type="button"
                                    id="bulk-clear"
                                    class="px-3 py-2 text-xs sm:text-sm font-semibold bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition"
                                >
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    @if($siswas->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" role="table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left">
                                            <input 
                                                type="checkbox" 
                                                id="select-all" 
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                title="Pilih semua siswa"
                                            >
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Nama Lengkap
                                        </th>
                                        <th scope="col" class="hidden sm:table-cell px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            NISN
                                        </th>
                                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Tempat Lahir
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Status Rapor
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="students-table-body">
                                    @foreach ($siswas as $siswa)
                                        @php
                                            $penilaian = $siswa->penilaians->first();
                                            $hasRapor = $penilaian !== null;
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition student-row" 
                                            data-name="{{ strtolower($siswa->nama_lengkap) }}" 
                                            data-nisn="{{ strtolower($siswa->nisn ?? '') }}"
                                            data-has-rapor="{{ $hasRapor ? 'true' : 'false' }}"
                                            data-student-id="{{ $siswa->id }}">
                                            <td class="px-6 py-4">
                                                <input 
                                                    type="checkbox" 
                                                    class="row-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                                    value="{{ $siswa->id }}"
                                                >
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $siswa->nama_lengkap }}</div>
                                                <div class="sm:hidden text-xs text-gray-600 mt-1">
                                                    NISN: {{ $siswa->nisn ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="hidden sm:table-cell px-6 py-4 text-sm text-gray-600">
                                                {{ $siswa->nisn ?? '-' }}
                                            </td>
                                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                                {{ $siswa->tempat_lahir ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($hasRapor)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        Sudah Dinilai
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                        </svg>
                                                        Belum Dinilai
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex gap-2 justify-end flex-wrap">
                                                    @if($hasRapor)
                                                        <a href="{{ route('guru.penilaian.edit', $penilaian) }}" 
                                                           class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold hover:bg-blue-200 transition"
                                                           title="Edit rapor {{ $siswa->nama_lengkap }}">
                                                            Edit Rapor
                                                        </a>
                                                        <a href="{{ route('guru.penilaian.print', $penilaian) }}" 
                                                           class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold hover:bg-green-200 transition" 
                                                           target="_blank"
                                                           title="Cetak rapor {{ $siswa->nama_lengkap }}">
                                                            Cetak
                                                        </a>
                                                    @else
                                                        <a href="{{ route('guru.siswa.penilaian.create', $siswa) }}" 
                                                           class="inline-flex items-center px-2 py-1 bg-green-600 text-white rounded text-xs font-semibold hover:bg-green-700 transition"
                                                           title="Buat rapor untuk {{ $siswa->nama_lengkap }}">
                                                            Buat Rapor
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('guru.siswa.edit', $siswa) }}" 
                                                       class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-semibold hover:bg-indigo-200 transition"
                                                       title="Edit data {{ $siswa->nama_lengkap }}">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('guru.siswa.destroy', $siswa) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus siswa {{ $siswa->nama_lengkap }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold hover:bg-red-200 transition"
                                                                title="Hapus {{ $siswa->nama_lengkap }}">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $siswas->links() }}
                        </div>
                    @else
                        <div class="px-6 py-16 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada siswa</h3>
                            <p class="mt-2 text-sm text-gray-600">Mulai dengan menambahkan siswa baru atau import dari file Excel.</p>
                            <div class="mt-6 flex justify-center gap-3">
                                <a href="{{ route('guru.siswa.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Tambah Siswa
                                </a>
                                <a href="{{ route('guru.siswa.import.show') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Import dari File
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="font-semibold text-yellow-800 text-lg">⚠️ Perhatian</p>
                            <p class="text-yellow-700 mt-1">Anda saat ini tidak ditugaskan sebagai wali kelas. Silakan hubungi Admin Sekolah.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Search & Filter Functionality
        const searchInput = document.getElementById('student-search');
        const statusFilter = document.getElementById('status-filter');
        const resetButton = document.getElementById('reset-filters');
        const studentRows = document.querySelectorAll('.student-row');
        const searchCountSpan = document.getElementById('search-count');
        const selectAllCheckbox = document.getElementById('select-all');

        function filterStudents() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const statusValue = statusFilter ? statusFilter.value : '';
            let visibleCount = 0;

            studentRows.forEach(row => {
                const name = row.getAttribute('data-name');
                const nisn = row.getAttribute('data-nisn');
                const hasRapor = row.getAttribute('data-has-rapor') === 'true';

                // Search match
                const searchMatch = searchTerm === '' || name.includes(searchTerm) || nisn.includes(searchTerm);
                
                // Status match
                let statusMatch = true;
                if (statusValue === 'has-rapor') {
                    statusMatch = hasRapor;
                } else if (statusValue === 'no-rapor') {
                    statusMatch = !hasRapor;
                }

                // Show/hide row
                if (searchMatch && statusMatch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                    // Uncheck hidden rows
                    const checkbox = row.querySelector('.row-checkbox');
                    if (checkbox) checkbox.checked = false;
                }
            });

            if (searchCountSpan) {
                searchCountSpan.textContent = visibleCount;
            }

            updateBulkActions();
        }

        if (searchInput) {
            searchInput.addEventListener('keyup', filterStudents);
            searchInput.addEventListener('change', filterStudents);
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', filterStudents);
        }

        if (resetButton) {
            resetButton.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                if (statusFilter) statusFilter.value = '';
                filterStudents();
            });
        }

        // Bulk Selection
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const visibleCheckboxes = Array.from(document.querySelectorAll('.row-checkbox')).filter(cb => {
                    return cb.closest('.student-row').style.display !== 'none';
                });
                
                visibleCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                
                updateBulkActions();
            });
        }

        // Individual checkboxes
        document.querySelectorAll('.row-checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            const bulkToolbar = document.getElementById('bulk-actions-toolbar');
            const bulkCount = document.getElementById('bulk-count');

            if (checkedBoxes.length > 0) {
                if (bulkToolbar) bulkToolbar.classList.remove('hidden');
                if (bulkCount) bulkCount.textContent = checkedBoxes.length;
            } else {
                if (bulkToolbar) bulkToolbar.classList.add('hidden');
            }

            // Highlight selected rows
            document.querySelectorAll('.student-row').forEach(row => {
                const cb = row.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    row.classList.add('bg-blue-50');
                } else {
                    row.classList.remove('bg-blue-50');
                }
            });
        }

        // Bulk Actions
        function getSelectedIds() {
            return Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
        }

        document.getElementById('bulk-export-csv')?.addEventListener('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                alert('Silakan pilih siswa terlebih dahulu');
                return;
            }
            // Implement CSV export
            console.log('Export CSV:', ids);
        });

        document.getElementById('bulk-export-pdf')?.addEventListener('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                alert('Silakan pilih siswa terlebih dahulu');
                return;
            }
            // Implement PDF export
            console.log('Export PDF:', ids);
        });

        document.getElementById('bulk-export-excel')?.addEventListener('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                alert('Silakan pilih siswa terlebih dahulu');
                return;
            }
            // Implement Excel export
            console.log('Export Excel:', ids);
        });

        document.getElementById('bulk-delete')?.addEventListener('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                alert('Silakan pilih siswa terlebih dahulu');
                return;
            }
            if (confirm(`Yakin ingin menghapus ${ids.length} siswa?`)) {
                // Implement bulk delete
                console.log('Delete:', ids);
            }
        });

        document.getElementById('bulk-clear')?.addEventListener('click', function() {
            document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
            if (selectAllCheckbox) selectAllCheckbox.checked = false;
            updateBulkActions();
        });

        // Initialize
        updateBulkActions();
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</x-app-layout>
