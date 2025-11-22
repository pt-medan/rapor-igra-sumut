# 🎯 UI/UX VISUAL MOCKUP RECOMMENDATIONS
## Dashboard Penilaian Siswa - Detailed Visual Guide

**Tanggal:** 22 November 2025  
**Status:** Visual Design Recommendations  

---

## 📐 DASHBOARD PAGE - PROPOSED LAYOUT

### **CURRENT LAYOUT (PROBLEM)**
```
┌─────────────────────────────────────┐
│ Navigation Bar                      │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Header: "Dashboard Guru"            │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Welcome Card + Stats + Buttons      │ ← TOO MUCH!
│ (Multiple CTAs, Info, Warning)      │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Student Quota Card (if applicable)  │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Filter Section (Period + Semester)  │ ← NEEDS MOVE UP!
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Stats Cards Grid (Duplicate!)       │ ← DUPLICATE!
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Analytics Section                   │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Consolidated Stats Cards            │ ← ANOTHER DUPLICATE!
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Recent Activities                   │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Student Table + Bulk Actions        │
└─────────────────────────────────────┘

⚠️ PROBLEM: User harus scroll 3-4 times untuk reach student table!
```

---

### **RECOMMENDED LAYOUT (SOLUTION)**

```
┌──────────────────────────────────────────────────────────────┐
│ COMPACT FILTER BAR (STICKY on scroll)                        │
│ [Tahun Ajaran ▼] [Semester ▼] [Filter] [Active: 2024/2025] │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│ SMART WELCOME SECTION (Condensed)                            │
│ ┌────────────────────────────────────────────────────────────┐
│ │ Selamat Datang, [Name]! | [Class] • [School]              │
│ │ Progress: [====80%====] 16/20 Siswa Dinilai              │
│ └────────────────────────────────────────────────────────────┘
│ ⚠️ PRIORITY ALERT (if needed):                              │
│ "3 siswa belum dinilai - [⚡ Input Rapor Sekarang →]"      │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│ PRIMARY STATS - SINGLE ROW (Responsive)                      │
│ ┌─────────────┬─────────────┬─────────────┬─────────────┐   │
│ │ Belum ⚡    │ Sudah ✓     │ Total       │ Kuota       │   │
│ │ 4           │ 16/20 (80%)│ 20          │ 18/25 (72%) │   │
│ └─────────────┴─────────────┴─────────────┴─────────────┘   │
│ [All clickable → filter student list]                        │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│ QUICK ACTIONS (Horizontal Layout)                            │
│ [Input Rapor]  [Kelola Siswa]  [Tambah Siswa]  [View More] │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│ STUDENT TABLE with MULTI-SELECT (MAIN CONTENT)               │
│ ☐ Select All | 📊 Student List with Bulk Actions           │
└──────────────────────────────────────────────────────────────┘

[IF SCROLL DOWN]
┌──────────────────────────────────────────────────────────────┐
│ ANALYTICS / INSIGHTS (Collapsible)                           │
│ [▼ Analytics] - Completion Trend, Status Breakdown, etc.     │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│ RECENT ACTIVITIES (Collapsible)                              │
│ [▼ Recent Activities] - 5 latest changes                     │
└──────────────────────────────────────────────────────────────┘

✅ BENEFIT: Only 2-3 sections visible immediately, scroll = less needed!
```

---

## 🎨 WELCOME CARD TRANSFORMATION

### **CURRENT (OVERLOADED)**
```
┌─────────────────────────────────────────────────┐
│ Selamat Datang, Ibu Fatimah!                    │
│ Kelas X-A • SMP Negeri 1 Medan                  │
│                                                 │
│ Total Siswa: 20 | Progress: 80%                 │
│                                                 │
│ ⚠️ ATTENTION: 3 siswa still awaiting rating    │
│                                                 │
│ [Input Rapor] [Kelola Siswa] [Tambah Siswa]    │
└─────────────────────────────────────────────────┘

❌ Problems:
- 6 different pieces of info
- 3 CTA buttons
- Color overflow
```

### **PROPOSED (SMART & FOCUSED)**
```
┌─────────────────────────────────────────────────┐
│ Selamat Datang, Ibu Fatimah! | Kelas X-A       │
│ ↓                                               │
│ Progress: [========80%========] 16/20 Dinilai  │
│                                                 │
│ ⚠️ URGENT: 3 siswa belum dinilai                │
│ [⚡ Input Rapor Sekarang →]                     │
└─────────────────────────────────────────────────┘

Or (if all completed):
┌─────────────────────────────────────────────────┐
│ Selamat Datang, Ibu Fatimah! | Kelas X-A       │
│ ↓                                               │
│ ✅ Luar Biasa! Semua siswa sudah dinilai!     │
│ Progress: [========100%========] 20/20 Dinilai │
│ [📊 View Reports →] [📥 Download →]            │
└─────────────────────────────────────────────────┘

✅ Benefits:
- Clear priority CTA
- Contextual message
- Only 2-3 action buttons
- Less cognitive load
```

---

## 📊 FILTER BAR REDESIGN

### **CURRENT POSITION (Problem)**
```
HERO SECTION
[Filter bar here - far from user's initial view]
STATS CARDS
[User sees other info before filtering!]
```

### **RECOMMENDED POSITION (Solution)**
```
NAVIGATION BAR
─────────────────────────────────────────────
[Tahun] [Semester] [Filter] [Active: 2024/2 Ganjil] ← STICKY on scroll
─────────────────────────────────────────────
HERO SECTION
MAIN CONTENT
```

### **FILTER BAR REDESIGN**

**Current Version:**
```
┌──────────────────────────────────────────────┐
│ Tahun Ajaran         │ Semester              │
│ [2024/2025  ▼]       │ [Ganjil ▼]            │
│                                              │
│ [Filter Button]                              │
│                                              │
│ Menampilkan: [2024/2025] [Ganjil]           │
└──────────────────────────────────────────────┘

❌ Takes too much vertical space
```

**Proposed Compact Version:**
```
┌──────────────────────────────────────────────┐
│ [2024/2025 ▼] [Ganjil ▼] [⚙️ Lebih] [🔄 Reset] │
│                                              │
│ (Optional) Active Period: 2024/2025-Ganjil  │
└──────────────────────────────────────────────┘

✅ More compact, sticky on scroll
✅ Easy to change period quickly
✅ Less vertical space used
```

---

## 👥 KELOLA SISWA PAGE REDESIGN

### **CURRENT STATE (Too Minimal)**
```
┌────────────────────────────────────────┐
│ Manajemen Siswa                        │
├────────────────────────────────────────┤
│ [+ Tambah] [📥 Massal] [📥 Export]    │
├────────────────────────────────────────┤
│ Simple Table:                          │
│ Nama | NISN | Aksi                     │
│ ... | ... | Edit Delete                │
│ ... | ... | Edit Delete                │
└────────────────────────────────────────┘

❌ No overview of data
❌ No search/filter
❌ No bulk operations
```

### **PROPOSED STATE (Rich & Functional)**
```
┌─────────────────────────────────────────────────────┐
│ HEADER SECTION                                      │
│ Manajemen Siswa - Kelas X-A                        │
│ [+ Tambah] [📥 Massal] [📤 Export] [⚙️ Advanced]  │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│ SUMMARY CARDS (Stats)                               │
│ ┌──────────┬──────────┬──────────┬──────────┐       │
│ │ Total    │ Dinilai  │ Pending  │ Kuota    │       │
│ │ 25       │ 18       │ 7        │ 18/25    │       │
│ └──────────┴──────────┴──────────┴──────────┘       │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│ SEARCH & FILTER BAR                                 │
│ [🔍 Cari nama/NISN...] [Status ▼] [Tanggal ▼]    │
│ [Clear Filter]                                      │
│ Results: 25 students                                │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│ ENHANCED TABLE with MULTI-SELECT                    │
│ ☐ | Nama           | NISN      | Status  | Aksi     │
│ ┌─┐──────────────┬──────────┬──────────┬─────────┐ │
│ │✓│ Ahmad Rizki  │ 12345001 │ ✓ Dinilai │ •••     │ │
│ │ │ Budi Santoso │ 12345002 │ ⏳ Pending│ •••     │ │
│ │ │ ...          │ ...      │ ...      │ ...      │ │
│ └─┴──────────────┴──────────┴──────────┴─────────┘ │
│                                                     │
│ BULK ACTIONS (when selected):                      │
│ ☑ 3 selected | [CSV] [PDF] [Excel] [Status] [x]  │
└─────────────────────────────────────────────────────┘

✅ Much better context & functionality!
```

---

## 📋 SEMUA RAPOR PAGE REDESIGN

### **CURRENT STATE (Very Basic)**
```
┌────────────────────────────────────┐
│ Manajemen Rapor                    │
├────────────────────────────────────┤
│ Nama Siswa | Kelas | Aksi          │
│ ... | ... | Cetak                  │
│ ... | ... | Cetak                  │
│ (Belum ada rapor yang dibuat)       │
└────────────────────────────────────┘

❌ No insights
❌ No filtering
❌ No status info
❌ No timestamps
```

### **PROPOSED STATE (Full Featured)**
```
┌──────────────────────────────────────────────────┐
│ HEADER                                            │
│ Manajemen Rapor - Periode 2024/2025 Ganjil      │
└──────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────┐
│ SUMMARY CARDS                                    │
│ ┌──────────┬──────────┬──────────┐              │
│ │ Total    │ Draft    │ Completed│              │
│ │ 45       │ 12       │ 33       │              │
│ └──────────┴──────────┴──────────┘              │
└──────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────┐
│ FILTER & SEARCH                                  │
│ [🔍 Search...] [Status ▼] [Class ▼] [Date ▼]   │
│ Showing: 45 rapors                              │
└──────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────┐
│ ENHANCED TABLE with ADDITIONAL COLUMNS            │
│ ☐ │ Nama      │ Kelas │ Status │ Updated │ Aksi  │
│ ┌─┼─────────┬─────┬────────┬─────────────┬────┐  │
│ │✓│ Ahmad   │ X-A │ ✓ Done │ 2h ago     │ ... │  │
│ │ │ Budi    │ X-A │ ⏳ Draft│ 1 day ago  │ ... │  │
│ │ │ Citra   │ X-B │ ✓ Done │ 3 days ago │ ... │  │
│ └─┴─────────┴─────┴────────┴─────────────┴────┘  │
│ [< Previous] [1 2 3 4 5] [Next >]                │
└──────────────────────────────────────────────────┘

BOTTOM SECTION (Bulk Operations):
[Print All] [Download (ZIP)] [Email] [Archive]

✅ Much better - actionable & informative!
```

---

## 🏫 PROFIL SEKOLAH FORM REDESIGN

### **CURRENT STATE (Basic Form)**
```
┌───────────────────────────────────────┐
│ Profil Sekolah                        │
├───────────────────────────────────────┤
│ Nama Sekolah *                        │
│ [_____________________]               │
│                                       │
│ Alamat *                              │
│ [_____________________]               │
│                                       │
│ NPSN *                                │
│ [_____________________]               │
│                                       │
│ Kepala Sekolah                        │
│ [_____________________]               │
│                                       │
│ Status                                │
│ [Negeri ▼]                            │
│                                       │
│ [Simpan]                              │
└───────────────────────────────────────┘

❌ No context
❌ No help text
❌ No sections/grouping
❌ No preview
```

### **PROPOSED STATE (Organized & Helpful)**
```
┌──────────────────────────────────────────────┐
│ PROFIL SEKOLAH                               │
│ Preview how school info appears in reports   │
├──────────────────────────────────────────────┤
│
│ SECTION 1: IDENTITAS SEKOLAH
│ ┌──────────────────────────────────────────┐
│ │ 🏫 Nama Sekolah *                       │
│ │ [_____________________________]           │
│ │ <Contoh: SMP Negeri 1 Medan>            │
│ │                                          │
│ │ 📋 NPSN *                                │
│ │ [________________]                       │
│ │ <8 digit number>                        │
│ │                                          │
│ │ 🎯 Status                                │
│ │ [Negeri ▼]  [Swasta ▼]                  │
│ └──────────────────────────────────────────┘
│
│ SECTION 2: KONTAK & ALAMAT
│ ┌──────────────────────────────────────────┐
│ │ 📍 Alamat Lengkap *                     │
│ │ [_________________________________]     │
│ │ [_________________________________]     │
│ │ <Minimal 10 characters>                 │
│ │                                          │
│ │ 🏘️ Kota/Kabupaten                      │
│ │ [__________________]                    │
│ │                                          │
│ │ 📮 Kode Pos                              │
│ │ [____________]                          │
│ └──────────────────────────────────────────┘
│
│ SECTION 3: KEPEMIMPINAN
│ ┌──────────────────────────────────────────┐
│ │ 👔 Kepala Sekolah                       │
│ │ [_____________________________]           │
│ │                                          │
│ │ 📞 Nomor Telepon                         │
│ │ [__________________]                    │
│ │                                          │
│ │ 📧 Email Sekolah                        │
│ │ [__________________@example.com]         │
│ └──────────────────────────────────────────┘
│
│ SECTION 4: BRANDING (Optional)
│ ┌──────────────────────────────────────────┐
│ │ 📸 Logo Sekolah                          │
│ │ [Upload Image] [Current: logo.png]      │
│ │ <Max 2MB, format: JPG/PNG>              │
│ │                                          │
│ │ 💬 Motto Sekolah                        │
│ │ [_________________________________]     │
│ └──────────────────────────────────────────┘
│
│ [Cancel] [Preview] [Save Changes]    │
└──────────────────────────────────────────────┘

✅ Much better - organized & user-friendly!
```

---

## 🧭 NAVIGATION MENU REDESIGN

### **CURRENT STATE (Flat)**
```
┌─────────────────────────────────────────────┐
│ [Logo] Dashboard | Kelola Siswa | Semua    │
│ | Profil Sekolah        [👤 Name ▼]        │
└─────────────────────────────────────────────┘

❌ No grouping
❌ All items same level
❌ No context indicator
```

### **PROPOSED STATE (Organized & Contextual)**
```
┌────────────────────────────────────────────────────┐
│ [Logo] SISTEM RAPOR                               │
├────────────────────────────────────────────────────┤
│                                                    │
│ 🏠 DASHBOARD                                      │
│    Dashboard                                       │
│    (Badge: 3 pending)                             │
│                                                    │
│ 📚 ASSESSMENT                                     │
│    📊 Semua Rapor                                │
│    ⚡ Input Rapor (shortcut)                     │
│                                                    │
│ 👥 STUDENTS                                       │
│    🎓 Kelola Siswa                               │
│    ➕ Tambah Siswa (shortcut)                    │
│                                                    │
│ ⚙️ SETTINGS                                       │
│    🏫 Profil Sekolah                             │
│    👤 Account Settings                           │
│    ❓ Help & Support                             │
│                                                    │
│ ─────────────────────────────────────────────    │
│ 📍 Current: Kelas X-A | Period: 2024/2 Ganjil   │
│ [Switch ▼]                                        │
│                                                    │
│ 👤 Nama Guru                                      │
│ Guru | Last login: 2h ago                        │
│ [Settings] [Logout]                              │
│                                                    │
└────────────────────────────────────────────────────┘

✅ Better organized, shows context, cleaner!
```

---

## 📱 MOBILE RESPONSIVE LAYOUTS

### **Smartphone (< 640px)**

**Dashboard:**
```
┌──────────────────────┐
│ E-RAPOR              │ ← Hamburger menu
├──────────────────────┤
│ Filter: 2024/2 Ganjil│ ← Compact filter
├──────────────────────┤
│ Welcome Card (compact)
│ Progress: 80%
│ ⚠️ 3 Pending
│                      │
│ [⚡ Input Rapor]     │ ← Primary action
│ [Kelola] [Tambah]    │
├──────────────────────┤
│ QUICK STATS (cards)  │
│ ┌─────────┐ ┌─────┐ │
│ │ Belum 4 │ │ ✓18 │ │
│ └─────────┘ └─────┘ │
├──────────────────────┤
│ STUDENTS (card list) │
│ ┌──────────────────┐ │
│ │ Ahmad Rizki      │ │
│ │ NISN: 12345001   │ │
│ │ Status: ✓ Dinilai│ │
│ │ [Edit] [Cetak]   │ │
│ └──────────────────┘ │
│ ┌──────────────────┐ │
│ │ Budi Santoso     │ │
│ │ NISN: 12345002   │ │
│ │ Status: ⏳ Pending
│ │ [Rapor] [...]    │ │
│ └──────────────────┘ │
└──────────────────────┘

✅ Optimized for thumb interaction
✅ Stack layout (not table)
✅ Cards show essential info
```

**Kelola Siswa:**
```
┌──────────────────────┐
│ Manajemen Siswa      │
├──────────────────────┤
│ [🔍 Search...]       │ ← Full width search
├──────────────────────┤
│ Quick Stats (compact)│
│ Total: 25 | Pending:7│
├──────────────────────┤
│ STUDENT LIST (cards) │
│ ┌──────────────────┐ │
│ │ ☐ Ahmad Rizki    │ │
│ │    NISN: 12345001│ │
│ │    Status: ✓     │ │
│ │    [Edit] [...]  │ │
│ └──────────────────┘ │
│ ┌──────────────────┐ │
│ │ ☐ Budi Santoso   │ │
│ │    NISN: 12345002│ │
│ │    Status: ⏳    │ │
│ │    [Rapor] [...]│ │
│ └──────────────────┘ │
│                      │
│ BULK ACTIONS        │
│ (when selected):    │
│ ☑ 2 selected        │
│ [CSV] [PDF] [x]     │
└──────────────────────┘

✅ Mobile-first card layout
✅ Bulk actions visible when needed
✅ Easy to select & action
```

---

## 🎯 KEYBOARD SHORTCUTS REFERENCE

**Proposed shortcuts to implement:**
```
╔════════════════════════════════════════╗
║ KEYBOARD SHORTCUTS REFERENCE           ║
╠════════════════════════════════════════╣
║ Global:                                ║
║ Cmd/Ctrl + K     → Global Search       ║
║ Cmd/Ctrl + /     → Show Help           ║
║ Cmd/Ctrl + B     → Go to Dashboard     ║
║                                        ║
║ Dashboard:                             ║
║ Cmd/Ctrl + D     → Manage Students     ║
║ Cmd/Ctrl + R     → View All Rapors     ║
║ Cmd/Ctrl + A     → Select All Students ║
║ Shift + C        → Clear Selection     ║
║ Cmd/Ctrl + E     → Export Selected     ║
║                                        ║
║ Navigation:                            ║
║ Cmd/Ctrl + .     → Focus Navigation    ║
║ Cmd/Ctrl + ,     → Open Preferences    ║
║ Cmd/Ctrl + Q     → Logout              ║
║                                        ║
║ Forms:                                 ║
║ Cmd/Ctrl + S     → Save/Submit         ║
║ Cmd/Ctrl + Z     → Undo                ║
║ Esc              → Cancel              ║
║                                        ║
║ Tables:                                ║
║ ↑ ↓ ← →         → Navigate Table      ║
║ Enter            → Open Row Detail     ║
║ Spacebar         → Select Row          ║
╚════════════════════════════════════════╝

Implementation tip: Show "?" on page for quick reference
```

---

## 🎨 COLOR & DESIGN TOKENS

**Recommended Design System:**
```
PRIMARY ACTIONS:
- Indigo-600 (#4F46E5) - Primary CTA buttons
- Indigo-700 (#4338CA) - Hover state
- Indigo-50 (#EEF2FF) - Background

SECONDARY ACTIONS:
- Blue-600 (#2563EB) - Secondary buttons
- Blue-50 (#EFF6FF) - Secondary background

SUCCESS:
- Green-600 (#16A34A) - Success badge, completed status
- Green-50 (#F0FDF4) - Success background

WARNING:
- Yellow-600 (#CA8A04) - Warnings, pending status
- Yellow-50 (#FEFCE8) - Warning background

ERROR:
- Red-600 (#DC2626) - Errors, danger actions
- Red-50 (#FEF2F2) - Error background

NEUTRAL:
- Gray-600 (#4B5563) - Tertiary text
- Gray-200 (#E5E7EB) - Borders
- Gray-50 (#F9FAFB) - Neutral background

Typography:
- Display: Figtree, 32px, Bold
- Heading: Figtree, 24px, Semibold
- Body: Figtree, 16px, Regular
- Small: Figtree, 14px, Regular

Spacing:
- xs: 4px
- sm: 8px
- md: 16px
- lg: 24px
- xl: 32px

Shadows:
- sm: 0 1px 2px 0 rgba(0,0,0,0.05)
- md: 0 4px 6px -1px rgba(0,0,0,0.1)
- lg: 0 10px 15px -3px rgba(0,0,0,0.1)

Border Radius:
- xs: 2px
- sm: 4px
- md: 8px
- lg: 12px
- full: 9999px
```

---

## ✅ IMPLEMENTATION CHECKLIST

### **Phase 5 Quick Wins:**
- [ ] Reorganize dashboard welcome card (remove extra CTAs)
- [ ] Consolidate stats cards (remove duplicates)
- [ ] Add search to Kelola Siswa page
- [ ] Add filter & status column to Semua Rapor
- [ ] Implement keyboard shortcut Cmd+K for global search
- [ ] Make bulk actions toolbar more visible with hint
- [ ] Improve mobile table UX (card layout)

### **Phase 6 Core Updates:**
- [ ] Move filter bar to sticky top position
- [ ] Implement multi-select on Kelola Siswa
- [ ] Add bulk operations toolbar to Kelola Siswa
- [ ] Add student detail modal preview
- [ ] Restructure Profil Sekolah form with sections
- [ ] Add breadcrumb navigation
- [ ] Reorganize navigation menu with grouping
- [ ] Add summary cards to all list pages

### **Phase 7 Advanced:**
- [ ] Add analytics dashboard to Semua Rapor
- [ ] Implement print preview modal
- [ ] Add activity audit trail
- [ ] Add notification system
- [ ] Implement help & documentation
- [ ] Add onboarding for new users

### **Phase 8 Polish:**
- [ ] Add CSS animations & transitions
- [ ] Implement dark mode support
- [ ] Optimize performance (lazy loading)
- [ ] Add real-time data sync (optional WebSocket)
- [ ] Improve accessibility (WCAG 2.1 AA)

---

## 🚀 DESIGN HANDOFF NOTES

**For Frontend Developer:**
1. Use provided Tailwind classes for consistency
2. Test across: iPhone 12/13, iPad, Desktop (1280px, 1920px)
3. Ensure touch targets are min 44px x 44px on mobile
4. Add loading states for all async actions
5. Add error boundaries for data loading failures
6. Use transitions (200-300ms) for all interactions
7. Add keyboard navigation support
8. Test with screen readers (for accessibility)

**For QA/Testing:**
1. Test on provided device matrix
2. Verify keyboard shortcuts work
3. Test form validations
4. Test bulk operations with 50+ items
5. Verify accessibility compliance
6. Test browser compatibility
7. Performance test with slow network

**For Product/Stakeholders:**
1. Get feedback on color scheme
2. Validate feature prioritization
3. Approve responsive designs
4. Review help documentation content
5. Plan user training/onboarding

---

## 📞 QUESTIONS & FEEDBACK

**Untuk diskusi lebih lanjut:**
- Mana recommendations yang paling valuable untuk users?
- Berapa budget untuk Phase 5-8?
- Siapa timeline yang realistic?
- Butuh user testing sebelum implementation?
- Ada specific use cases yang belum tercovered?

**Next meeting:** Review & prioritization bersama stakeholders!
