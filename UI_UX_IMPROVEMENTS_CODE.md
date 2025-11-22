# 🎨 UI/UX IMPROVEMENTS - Visual Wireframes & Code Examples

**Status:** Design Guide & Code Snippets  
**Tanggal:** 22 November 2025

---

## 📐 VISUAL WIREFRAMES

### 1. Dashboard - Improved Layout

```
┌─────────────────────────────────────────────────────────────────┐
│ E-RAPOR IGRA SUMUT                                         👤▼  │
├─────────────────────────────────────────────────────────────────┤
│                         STICKY HEADER                            │
│ Dashboard > Periode: 2024/2025 Ganjil                     [🔔 5]│
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ 👋 Selamat Datang, Ibu Siti! (Kelas X IPA 1)            │ │
│ │                                                           │ │
│ │ ┌──────────────┬──────────────┬──────────────────────┐   │ │
│ │ │ Total Siswa  │ Sudah Dinilai│ Belum Dinilai        │   │ │
│ │ │     34       │   28 (82%)   │    6 (18%)           │   │ │
│ │ └──────────────┴──────────────┴──────────────────────┘   │ │
│ │                                                           │ │
│ │ ⚠️ PERHATIAN: 6 siswa masih menunggu rating               │ │
│ │ [🔥 INPUT RAPOR SEKARANG]  [👥 Kelola Siswa]             │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
│ ┌──────────────────────┬──────────────────────┐                 │
│ │   LEFT PANEL (60%)   │   RIGHT PANEL (40%)  │                 │
│ │                      │                      │                 │
│ │ Progress Section:    │ Quick Links:         │                 │
│ │ [████████░░ 82%]     │ • Input Rapor        │                 │
│ │ Insights & Tips:     │ • Kelola Siswa       │                 │
│ │ - Great progress!    │ • Lihat Semua Rapor  │                 │
│ │ - Focus on 6 pending │ • Profil Sekolah     │                 │
│ │                      │                      │                 │
│ │ Recent Activity:     │ Recent Activity:     │                 │
│ │ • John - 2 min ago   │ • Modified 5 rapor   │                 │
│ │ • Mary - 1 hour ago  │ • Exported CSV       │                 │
│ │                      │                      │                 │
│ │ (See all →)         │ (See all →)          │                 │
│ └──────────────────────┴──────────────────────┘                 │
│                                                                   │
│ 📊 DAFTAR SISWA (Preview - Top 5)                                │
│                                                                   │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ [✓] │ Nama Siswa        │ Status        │ Aksi              │ │
│ ├─────┼───────────────────┼───────────────┼──────────────────┤ │
│ │ [ ] │ Ahmad Nasution    │ ✓ Dinilai     │ [Edit] [Cetak]   │ │
│ │ [ ] │ Budi Santoso      │ ✓ Dinilai     │ [Edit] [Cetak]   │ │
│ │ [ ] │ Citra Dewi        │ ⏳ Belum      │ [Buat] [Info]    │ │
│ │ [ ] │ Diana Putra       │ ⏳ Belum      │ [Buat] [Info]    │ │
│ │ [ ] │ Eka Maharani      │ ✓ Dinilai     │ [Edit] [Cetak]   │ │
│ ├─────┴───────────────────┴───────────────┴──────────────────┤ │
│ │ Showing 5 of 34 | [View All →]                              │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘

STICKY BOTTOM (Mobile):
┌─────────────────────┐
│ 🏠 Dashboard 📊 Data 👥 Siswa 🏫 Sekolah │
└─────────────────────┘

FLOATING ACTION BUTTON:
┌────────┐
│ 🔥     │ ← Input Rapor (Primary)
│ ⋯ ▼    │ ← Quick menu (Secondary)
└────────┘
```

---

### 2. Kelola Siswa - Enhanced Layout

```
┌─────────────────────────────────────────────────────────────────┐
│ E-RAPOR IGRA SUMUT                                         👤▼  │
├─────────────────────────────────────────────────────────────────┤
│ Dashboard > Kelola Siswa > Kelas X IPA 1                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│ 📚 DAFTAR SISWA - Kelas X IPA 1                                 │
│ Total: 34 siswa | Sudah Dinilai: 28 | Belum: 6 | Tingkat: 82%  │
│                                                                   │
│ ┌────────────────────────────────────────┐  [📥 Import] [📤 Exp] │
│ │ 🔍 Cari nama atau NISN              │  [➕ Tambah]  [⚙️ Sett]│
│ └────────────────────────────────────────┘                       │
│                                                                   │
│ Status: [Semua ▼] | Sort by: [Nama ▼]                          │
│                                                                   │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ [✓] │ Nama Lengkap        │ NISN      │ Status │ Aksi    │ │
│ ├──────┼─────────────────────┼───────────┼────────┼─────────┤ │
│ │ [✓] │ Ahmad Nasution      │ 1234567   │ ✓ ✓ ✓  │ [→]    │ │
│ │ [ ] │ Budi Santoso        │ 1234568   │ ⏳ ✗ ✗  │ [→]    │ │
│ │ [ ] │ Citra Dewi          │ 1234569   │ ✓ ✓ ✗  │ [→]    │ │
│ │ [ ] │ Diana Putra         │ 1234570   │ ⏳ ✗ ✗  │ [→]    │ │
│ │ [ ] │ Eka Maharani        │ 1234571   │ ✓ ✗ ✗  │ [→]    │ │
│ │ [ ] │ Fajar Hermawan      │ 1234572   │ ✓ ✓ ✓  │ [→]    │ │
│ └──────┴─────────────────────┴───────────┴────────┴─────────┘ │
│ Showing 1-6 of 34 | [< Prev] [1] [2] [3] [4] [5] [Next >]      │
│                                                                   │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ ✓ 1 siswa dipilih                                           │ │
│ │ [Export CSV] [Export PDF] [Export Excel]                    │ │
│ │ [Update Status ▼] [Print Labels] [Hapus Pilihan]            │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

**Status Icons Legend:**
```
✓ = Dinilai (Green)
⏳ = Belum Dinilai (Yellow)
✗ = Error/Belum Updated

Kolom Status menunjukkan: [Rapor] [Email] [Permission]
```

---

### 3. Semua Rapor - Redesigned View

```
┌─────────────────────────────────────────────────────────────────┐
│ E-RAPOR IGRA SUMUT                                         👤▼  │
├─────────────────────────────────────────────────────────────────┤
│ Dashboard > Semua Rapor                                    [🔔 2]│
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│ 📊 RIWAYAT PENILAIAN SEMUA SISWA                                 │
│                                                                   │
│ Quick Stats:                                                     │
│ ┌────────┬────────┬────────┬────────┐                           │
│ │ Total  │ Dinilai│ Draft  │ Belum  │                           │
│ │  120   │   95   │   15   │   10   │                           │
│ └────────┴────────┴────────┴────────┘                           │
│                                                                   │
│ Filters & Search:                                               │
│ ┌──────────────────────────────────────────────────────────────┐│
│ │ Tahun: [2024/2025 ▼] Semester: [Ganjil ▼] [Genap] [Semua]  ││
│ │ Status: [☑ Dinilai] [☑ Draft] [☐ Belum] [☑ Arsip]            ││
│ │ Kelas: [X IPA 1 ▼]   Search: [_________________]             ││
│ └──────────────────────────────────────────────────────────────┘│
│                                                                   │
│ View: [📋 Table] [📅 Timeline] [📊 Stats]                        │
│                                                                   │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ [✓] │ Nama Siswa  │ Periode   │ Status │ Guru  │ Aksi    │ │
│ ├──────┼─────────────┼───────────┼────────┼───────┼─────────┤ │
│ │ [ ] │ Ahmad N.    │ 24/25 G.  │ Dinilai│ Siti  │ [→]    │ │
│ │ [✓] │ Budi S.     │ 24/25 G.  │ Draft  │ Siti  │ [→]    │ │
│ │ [ ] │ Citra D.    │ 24/25 G.  │ Belum  │ Siti  │ [→]    │ │
│ │ [ ] │ Diana P.    │ 24/25 Gen.│ Dinilai│ Siti  │ [→]    │ │
│ │ [ ] │ Eka M.      │ 23/24 G.  │ Arsip  │ Siti  │ [→]    │ │
│ └──────┴─────────────┴───────────┴────────┴───────┴─────────┘ │
│ Showing 1-5 of 120 | [< Prev] [1][2][3]...[24] [Next >]       │
│                                                                   │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ ✓ 1 rapor dipilih                                           │ │
│ │ [Export to PDF] [Export to ZIP] [Print] [Archive]           │ │
│ │ [Send Reminder] [Bulk Update Status]                        │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

### 4. Profil Sekolah - Tab-Based Design

```
┌─────────────────────────────────────────────────────────────────┐
│ E-RAPOR IGRA SUMUT                                         👤▼  │
├─────────────────────────────────────────────────────────────────┤
│ Dashboard > Profil Sekolah                                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│ 🏫 PROFIL SEKOLAH                                               │
│                                                                   │
│ ┌──────────┐ ────────────────────────────────────────────────  │
│ │          │ Nama: SMA NEGERI 1 MEDAN                           │
│ │  LOGO    │ NPSN: 20102001                                    │
│ │  [IMG]   │ Status: Negeri                                     │
│ │          │ Website: www.sma1medan.sch.id                     │
│ └──────────┘                                                    │
│                                                                   │
│ Quick Stats:                                                     │
│ ┌────────┬────────┬────────┐                                     │
│ │ 25 Guru│ 500 Sisw│ 18 Kelas│                                  │
│ └────────┴────────┴────────┘                                     │
│                                                                   │
│ [📝 Edit Mode]  [🔄 Reset]  [💾 Simpan]                         │
│                                                                   │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ [Dasar ▸] [Kontak] [Kepemimpinan] [Statistik] [Pengaturan] │ │
│ ├─────────────────────────────────────────────────────────────┤ │
│ │                                                             │ │
│ │ Informasi Dasar:                                            │ │
│ │                                                             │ │
│ │ Nama Sekolah:                                              │ │
│ │ [SMA NEGERI 1 MEDAN____________________________]            │ │
│ │                                                             │ │
│ │ NPSN:                                                       │ │
│ │ [20102001________________________________]                │ │
│ │                                                             │ │
│ │ Status:                                                     │ │
│ │ [Negeri ▼]                                                  │ │
│ │                                                             │ │
│ │ Website:                                                    │ │
│ │ [www.sma1medan.sch.id______________________]              │ │
│ │                                                             │ │
│ │ Tahun Berdiri:                                              │ │
│ │ [1995________________]                                      │ │
│ │                                                             │ │
│ │ Logo Sekolah:                                               │ │
│ │ [Pilih File] atau [Drag & Drop]                            │ │
│ │ ℹ️ Dimensi: 200x200px, Format: PNG/JPG, Max: 2MB           │ │
│ │                                                             │ │
│ │ ✓ Perubahan auto-save setiap 30 detik                       │ │
│ │ ✓ Terakhir disimpan: 22 Nov 2025 14:30                     │ │
│ │                                                             │ │
│ │ [🔙 Batal]  [💾 Simpan Perubahan]                           │ │
│ │                                                             │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## 💻 CODE EXAMPLES

### 1. Enhanced Search Component (Alpine.js)

```html
<!-- resources/views/components/enhanced-search.blade.php -->
<div x-data="search()" class="mb-4">
    <div class="relative">
        <input 
            type="text" 
            x-model="query"
            @input="debounce()"
            @keydown.enter="search"
            placeholder="Cari berdasarkan nama, NISN, atau email..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
        <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>
    
    <!-- Search Results Preview -->
    <template x-if="results.length > 0 && showResults">
        <div class="absolute top-12 left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
            <template x-for="result in results.slice(0, 5)" :key="result.id">
                <div @click="selectResult(result)" class="px-4 py-2 hover:bg-gray-50 cursor-pointer border-b">
                    <p class="font-medium text-gray-900" x-text="result.name"></p>
                    <p class="text-sm text-gray-600" x-text="result.nisn"></p>
                </div>
            </template>
        </div>
    </template>
</div>

<script>
function search() {
    return {
        query: '',
        results: [],
        timeout: null,
        showResults: false,
        
        debounce() {
            this.showResults = true;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.search(), 300);
        },
        
        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }
            
            try {
                const response = await fetch(`/api/search?q=${this.query}`);
                this.results = await response.json();
            } catch (error) {
                console.error('Search error:', error);
            }
        },
        
        selectResult(result) {
            this.query = result.name;
            this.showResults = false;
            // Trigger filter atau action
            this.$dispatch('search-selected', result);
        }
    }
}
</script>
```

---

### 2. Status Badge Component

```html
<!-- resources/views/components/status-badge.blade.php -->
@props(['status' => 'pending', 'size' => 'md'])

@php
    $statusConfig = [
        'completed' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'icon' => '✓',
            'label' => 'Dinilai'
        ],
        'pending' => [
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'icon' => '⏳',
            'label' => 'Belum Dinilai'
        ],
        'draft' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-800',
            'icon' => '📝',
            'label' => 'Draft'
        ],
        'error' => [
            'bg' => 'bg-red-100',
            'text' => 'text-red-800',
            'icon' => '❌',
            'label' => 'Error'
        ]
    ];
    
    $config = $statusConfig[$status] ?? $statusConfig['pending'];
    $sizeClass = $size === 'sm' ? 'px-2 py-1 text-xs' : 'px-3 py-1.5 text-sm';
@endphp

<span class="inline-flex items-center gap-1 {{ $sizeClass }} font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}"
      title="{{ $config['label'] }}"
      aria-label="Status: {{ $config['label'] }}">
    <span>{{ $config['icon'] }}</span>
    <span>{{ $config['label'] }}</span>
</span>
```

**Usage:**
```blade
<x-status-badge status="completed" />
<x-status-badge status="pending" size="sm" />
<x-status-badge status="draft" />
```

---

### 3. Bulk Actions Toolbar Component

```html
<!-- resources/views/components/bulk-actions-toolbar.blade.php -->
@props(['total' => 0, 'actions' => []])

<div x-show="selectedCount > 0" 
     @click.outside="deselectAll()"
     class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 flex items-center justify-between gap-4 animate-slide-down">
    
    <!-- Selection Info -->
    <div class="flex items-center gap-3">
        <span class="text-sm font-semibold text-gray-700">
            <span class="font-bold text-blue-600" x-text="selectedCount"></span>
            <span x-text="`item${selectedCount > 1 ? 's' : ''}`"></span> dipilih
        </span>
        <span class="text-xs text-gray-500">
            (<span x-text="Math.round((selectedCount / {{ $total }}) * 100)"></span>%)
        </span>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex flex-wrap items-center gap-2">
        @foreach($actions as $action)
            <button 
                type="button"
                @click="{{ $action['action'] }}"
                title="{{ $action['title'] }}"
                class="px-3 py-2 text-xs sm:text-sm font-semibold {{ $action['color'] }} rounded-lg hover:opacity-80 transition flex items-center gap-1"
            >
                <span>{{ $action['icon'] }}</span>
                <span class="hidden sm:inline">{{ $action['label'] }}</span>
            </button>
        @endforeach
        
        <!-- Clear Selection -->
        <button 
            type="button"
            @click="deselectAll()"
            class="px-3 py-2 text-xs sm:text-sm font-semibold bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition"
        >
            Bersihkan
        </button>
    </div>
</div>
```

**Usage:**
```blade
<x-bulk-actions-toolbar 
    :total="$students->count()"
    :actions="[
        [
            'label' => 'Export CSV',
            'icon' => '📋',
            'color' => 'bg-green-600 text-white',
            'action' => 'exportCsv()',
            'title' => 'Export selected students to CSV'
        ],
        [
            'label' => 'Export PDF',
            'icon' => '📄',
            'color' => 'bg-red-600 text-white',
            'action' => 'exportPdf()',
            'title' => 'Export selected students to PDF'
        ],
        [
            'label' => 'Delete',
            'icon' => '🗑️',
            'color' => 'bg-red-600 text-white',
            'action' => 'deleteSelected()',
            'title' => 'Delete selected students'
        ]
    ]"
/>
```

---

### 4. Tab Component

```html
<!-- resources/views/components/tabs.blade.php -->
@props(['tabs' => [], 'active' => 0])

<div x-data="{ activeTab: {{ $active }} }" class="w-full">
    <!-- Tab Buttons -->
    <div class="border-b border-gray-200 flex overflow-x-auto">
        @foreach($tabs as $index => $tab)
            <button
                @click="activeTab = {{ $index }}"
                :class="{ 
                    'border-b-2 border-blue-500 text-blue-600': activeTab === {{ $index }},
                    'border-b-2 border-transparent text-gray-600 hover:text-gray-800': activeTab !== {{ $index }}
                }"
                class="px-4 py-3 font-medium whitespace-nowrap transition"
                role="tab"
                :aria-selected="activeTab === {{ $index }}"
            >
                <span class="mr-2">{{ $tab['icon'] ?? '' }}</span>
                {{ $tab['label'] }}
            </button>
        @endforeach
    </div>
    
    <!-- Tab Content -->
    @foreach($tabs as $index => $tab)
        <div 
            x-show="activeTab === {{ $index }}"
            class="py-4"
            role="tabpanel"
        >
            {!! $tab['content'] !!}
        </div>
    @endforeach
</div>
```

**Usage:**
```blade
<x-tabs :tabs="[
    [
        'label' => 'Informasi Dasar',
        'icon' => '📝',
        'content' => view('school.tabs.basic', $data)->render()
    ],
    [
        'label' => 'Kontak & Lokasi',
        'icon' => '📍',
        'content' => view('school.tabs.contact', $data)->render()
    ],
    [
        'label' => 'Kepemimpinan',
        'icon' => '👔',
        'content' => view('school.tabs.leadership', $data)->render()
    ]
]" :active="0" />
```

---

### 5. Notification Bell Component

```html
<!-- resources/views/components/notification-bell.blade.php -->
@props(['count' => 0, 'notifications' => []])

<div x-data="notificationBell()" class="relative">
    <!-- Bell Button -->
    <button 
        @click="open = !open"
        class="relative p-2 text-indigo-100 hover:bg-indigo-700 rounded-md transition"
        aria-label="Notifications"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        
        <!-- Badge -->
        @if($count > 0)
            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full animate-pulse">
                {{ $count }}
            </span>
        @endif
    </button>
    
    <!-- Dropdown -->
    <div x-show="open" 
         @click.outside="open = false"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl z-50">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Notifikasi</h3>
        </div>
        
        <!-- Notifications List -->
        @if($notifications->isEmpty())
            <div class="px-4 py-6 text-center text-gray-500">
                <p>Tidak ada notifikasi baru</p>
            </div>
        @else
            <div class="max-h-96 overflow-y-auto">
                @foreach($notifications as $notification)
                    <div class="px-4 py-3 border-b hover:bg-gray-50 cursor-pointer transition">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $notification->title }}
                        </p>
                        <p class="text-xs text-gray-600 mt-1">
                            {{ $notification->message }}
                        </p>
                        <p class="text-xs text-gray-400 mt-2">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
        
        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-200 text-center">
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Lihat Semua Notifikasi →
            </a>
        </div>
    </div>
</div>

<script>
function notificationBell() {
    return {
        open: false
    }
}
</script>
```

---

### 6. Enhanced Table Component with Sorting & Filtering

```html
<!-- resources/views/components/data-table.blade.php -->
@props(['columns' => [], 'rows' => [], 'sortable' => true, 'filterable' => true])

<div x-data="dataTable()" class="w-full">
    <!-- Filter Bar -->
    @if($filterable)
    <div class="mb-4 flex gap-2 flex-wrap">
        <input 
            type="text" 
            x-model="search"
            @input="filterRows()"
            placeholder="Cari..."
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
        <select 
            x-model="sortBy"
            @change="sortRows()"
            class="px-3 py-2 border border-gray-300 rounded-lg"
        >
            <option value="">Sort by...</option>
            @foreach($columns as $col)
                @if($col['sortable'] ?? true)
                    <option value="{{ $col['key'] }}">{{ $col['label'] }}</option>
                @endif
            @endforeach
        </select>
        <select 
            x-model="sortOrder"
            @change="sortRows()"
            class="px-3 py-2 border border-gray-300 rounded-lg"
        >
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
    </div>
    @endif
    
    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    @foreach($columns as $col)
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">
                            @if($col['sortable'] ?? true)
                                <button 
                                    @click="setSortBy('{{ $col['key'] }}')"
                                    class="flex items-center gap-1 hover:text-blue-600"
                                >
                                    {{ $col['label'] }}
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"></path>
                                    </svg>
                                </button>
                            @else
                                {{ $col['label'] }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <template x-for="row in displayedRows" :key="row.id">
                    <tr class="hover:bg-gray-50 transition">
                        @foreach($columns as $col)
                            <td class="px-4 py-3">
                                <span x-text="row.{{ $col['key'] }}"></span>
                            </td>
                        @endforeach
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4 flex justify-between items-center">
        <p class="text-sm text-gray-600">
            Showing <span x-text="(currentPage - 1) * pageSize + 1"></span> to 
            <span x-text="Math.min(currentPage * pageSize, filteredRows.length)"></span> of 
            <span x-text="filteredRows.length"></span>
        </p>
        <div class="flex gap-2">
            <button 
                @click="previousPage()"
                :disabled="currentPage === 1"
                class="px-3 py-1 border border-gray-300 rounded disabled:opacity-50"
            >
                Previous
            </button>
            <button 
                @click="nextPage()"
                :disabled="currentPage * pageSize >= filteredRows.length"
                class="px-3 py-1 border border-gray-300 rounded disabled:opacity-50"
            >
                Next
            </button>
        </div>
    </div>
</div>

<script>
function dataTable() {
    return {
        search: '',
        sortBy: '',
        sortOrder: 'asc',
        currentPage: 1,
        pageSize: 10,
        rows: {{ Js::from($rows) }},
        filteredRows: [],
        displayedRows: [],
        
        init() {
            this.filteredRows = this.rows;
            this.updateDisplay();
        },
        
        filterRows() {
            this.currentPage = 1;
            this.filteredRows = this.rows.filter(row => {
                return JSON.stringify(row).toLowerCase().includes(this.search.toLowerCase());
            });
            this.updateDisplay();
        },
        
        sortRows() {
            this.filteredRows.sort((a, b) => {
                let aVal = a[this.sortBy];
                let bVal = b[this.sortBy];
                
                if (typeof aVal === 'string') {
                    aVal = aVal.toLowerCase();
                    bVal = bVal.toLowerCase();
                }
                
                return this.sortOrder === 'asc' 
                    ? aVal > bVal ? 1 : -1
                    : aVal < bVal ? 1 : -1;
            });
            this.updateDisplay();
        },
        
        setSortBy(key) {
            if (this.sortBy === key) {
                this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy = key;
                this.sortOrder = 'asc';
            }
            this.sortRows();
        },
        
        updateDisplay() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            this.displayedRows = this.filteredRows.slice(start, end);
        },
        
        nextPage() {
            if (this.currentPage * this.pageSize < this.filteredRows.length) {
                this.currentPage++;
                this.updateDisplay();
            }
        },
        
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.updateDisplay();
            }
        }
    }
}
</script>
```

---

## 🎨 CSS Utilities

```css
/* resources/css/ui-improvements.css */

/* Consistent spacing */
.card-spacing { @apply p-4 sm:p-6 lg:p-8; }
.section-spacing { @apply mb-6 last:mb-0; }

/* Status colors */
.badge-success { @apply px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold; }
.badge-warning { @apply px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold; }
.badge-danger { @apply px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold; }
.badge-info { @apply px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold; }

/* Interactive elements */
.btn-primary { @apply px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition; }
.btn-secondary { @apply px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition; }
.btn-ghost { @apply px-4 py-2 bg-transparent border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition; }

/* Animations */
@keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.animate-slide-down { animation: slideDown 0.3s ease-out; }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }

/* Responsive helpers */
@media (max-width: 640px) {
    .hidden-mobile { @apply hidden; }
    .show-mobile { @apply block; }
    .stack-mobile { @apply flex flex-col; }
}

/* Focus states for accessibility */
.focus-ring { @apply focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500; }
```

---

## 🚀 Implementation Checklist

```
□ Create design mockups in Figma
□ Review with stakeholders
□ Create components as Blade components
□ Implement search functionality
□ Add bulk actions toolbar
□ Redesign "Semua Rapor" page
□ Improve Profil Sekolah with tabs
□ Add notification bell
□ Implement sorting/filtering
□ Add breadcrumb navigation
□ Mobile testing
□ Accessibility audit
□ Performance testing
□ User testing with 5-10 gurus
□ Iterate based on feedback
□ Deploy to production
```

---

**Ready to implement! Let's make the UI/UX outstanding! 🎨✨**
