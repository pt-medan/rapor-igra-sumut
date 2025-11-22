# 🚀 Phase 1 Quick Test Checklist

**Untuk Testing Manual Cepat (30-60 menit)**

---

## ✅ PRE-DEPLOYMENT CHECKS (5 menit)

- [ ] Git status bersih (no uncommitted changes)
- [ ] Branch: `phase-1-ui-improvements` atau sudah merge ke `main`
- [ ] Database backup dibuat: `mysqldump` atau `pg_dump`
- [ ] `.env` file production ready (APP_DEBUG=false)
- [ ] Run: `php artisan config:cache`
- [ ] Run: `php artisan route:cache`
- [ ] Run: `php artisan view:cache`
- [ ] No errors in Laravel logs: `tail -f storage/logs/laravel.log`

---

## 🎯 CRITICAL FUNCTIONALITY (15 menit)

### Dashboard
- [ ] Login sebagai guru → Dashboard loads < 3 detik
- [ ] Stat cards tampil: Total Siswa, Penilaian Belum Lengkap, Rapor Cetak
- [ ] Angka di stat cards akurat (cek vs database)
- [ ] Button "Kelola Siswa" → redirect ke `/guru/siswa`
- [ ] Button "Tambah Siswa Baru" → redirect ke `/guru/siswa/create`
- [ ] Collapsible section "Ringkasan Penilaian" → bisa toggle open/close
- [ ] Filter by kelompok kelas → table update correctly

### Kelola Siswa Page
- [ ] Page loads dengan pagination (default 20 per page)
- [ ] Search box: ketik "ahmad" → table filter instantly (no page reload)
- [ ] Filter status: pilih "Penilaian Lengkap" → filter works
- [ ] Pagination: click Next → page 2 loads
- [ ] Per page dropdown: pilih 50 → shows 50 students
- [ ] Checkbox: select 3 students → bulk action toolbar muncul
- [ ] Button "Edit" pada student → redirect ke edit page
- [ ] Button "Hapus" → confirmation modal muncul

### Navigation Menu
- [ ] Navigation shows: Dashboard, Kelola Siswa, Profil Sekolah (3 items only)
- [ ] "Semua Rapor" TIDAK ada dalam menu (sudah dihapus)
- [ ] SVG icons tampil (bukan emoji)
- [ ] Active menu item highlighted correctly
- [ ] Mobile (< 768px): hamburger menu berfungsi
- [ ] Mobile: menu items sama dengan desktop

### Breadcrumb
- [ ] Navigate ke `/guru/siswa/create`
- [ ] Breadcrumb shows: "Dashboard / Kelola Siswa / Tambah Siswa Baru"
- [ ] Click "Kelola Siswa" in breadcrumb → redirect correctly
- [ ] Last item (current page) NOT clickable

---

## 🔒 SECURITY CHECKS (5 menit)

- [ ] Logout → akses `/dashboard` → redirect ke login page
- [ ] Login sebagai Guru A → buat student
- [ ] Login sebagai Guru B → coba edit student dari Guru A → 403 Forbidden
- [ ] Search box: input `' OR 1=1 --` → no SQL error, safe handling
- [ ] Inspect form: `@csrf` token present di semua POST/DELETE forms

---

## 📱 RESPONSIVE DESIGN (10 menit)

### Mobile (375px)
- [ ] Dashboard: stat cards stack vertically
- [ ] Kelola Siswa: table scrollable horizontal
- [ ] Navigation: hamburger menu works
- [ ] No horizontal scroll pada page

### Tablet (768px)
- [ ] Dashboard: two-column layout tampil
- [ ] Sidebar visible (not hidden)
- [ ] All buttons accessible

### Desktop (1920px)
- [ ] Layout tidak overly stretched
- [ ] Content centered dengan max-width

---

## 🌐 CROSS-BROWSER (10 menit)

- [ ] **Chrome**: Dashboard, Kelola Siswa, Navigation → all work
- [ ] **Firefox**: Search function, pagination → all work
- [ ] **Safari** (macOS): SVG icons, Alpine.js collapsible → all work
- [ ] **Edge**: Basic functionality → all work

---

## ♿ ACCESSIBILITY QUICK CHECK (5 menit)

- [ ] Tab key: focus moves through all buttons/links in logical order
- [ ] Tab key: visible focus indicator on each element
- [ ] Inspect breadcrumb: `aria-label="Breadcrumb"` present
- [ ] Inspect breadcrumb: `aria-current="page"` on last item
- [ ] All form inputs have `<label>` tags

---

## ⚡ PERFORMANCE CHECK (5 menit)

- [ ] Dashboard load time < 2 seconds (Chrome DevTools Network tab)
- [ ] Kelola Siswa load time < 3 seconds (with 100 students)
- [ ] Real-time search response < 200ms per keystroke
- [ ] Open Laravel Debugbar → query count < 10 for dashboard
- [ ] No N+1 query problems

---

## 🔄 REGRESSION CHECK (5 menit)

- [ ] Create new student → form works
- [ ] Edit existing student → update works
- [ ] Delete student → deletion works (with confirmation)
- [ ] Navigate to assessment page → form loads
- [ ] Fill assessment data → save works
- [ ] Generate rapor PDF → PDF created successfully

---

## 🚨 CRITICAL BUGS CHECK

Jika menemukan issue ini, **JANGAN DEPLOY**:

- [ ] ❌ RelationNotFoundException error muncul lagi
- [ ] ❌ 500 Internal Server Error pada dashboard
- [ ] ❌ Pagination tidak berfungsi (stuck di page 1)
- [ ] ❌ Search box tidak filter anything
- [ ] ❌ Teachers bisa lihat students dari guru lain
- [ ] ❌ CSRF token error saat submit form
- [ ] ❌ Layout completely broken di mobile
- [ ] ❌ Navigation menu tidak tampil

---

## ✅ DEPLOYMENT GO/NO-GO

**ALL critical checks passed?**

- [ ] ✅ Functionality: All features work
- [ ] ✅ Security: Authorization & CSRF OK
- [ ] ✅ Responsive: Mobile/tablet/desktop OK
- [ ] ✅ Performance: Load times acceptable
- [ ] ✅ Regression: Existing features still work
- [ ] ✅ No critical bugs found

**Decision:**
- [ ] 🟢 **GO** - Deploy to production
- [ ] 🔴 **NO-GO** - Fix issues first

**If NO-GO, list blockers:**
1. 
2. 
3. 

---

## 🎯 POST-DEPLOYMENT VERIFICATION (10 menit)

Setelah deploy ke production:

- [ ] Verify production site loads: https://your-domain.com
- [ ] Test login with real account
- [ ] Navigate dashboard → kelola siswa → edit student
- [ ] Check Laravel logs: `tail -f storage/logs/laravel.log`
- [ ] Monitor server resources (CPU, memory)
- [ ] Test from different devices (laptop, tablet, phone)
- [ ] Ask 2-3 teachers to test and provide feedback

---

## 📞 ROLLBACK PROCEDURE

**If critical issues found in production:**

```bash
# 1. Rollback code
git log --oneline  # Find previous commit hash
git checkout {previous_commit_hash}

# 2. Clear caches
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 3. Restart services
# (depends on your server setup)
sudo systemctl restart php-fpm
sudo systemctl restart nginx

# 4. Verify rollback successful
# Test dashboard and kelola siswa page
```

---

## 📝 TESTING NOTES

**Date Tested:** _______________  
**Tested By:** _______________  
**Environment:** Development / Staging / Production  

**Issues Found:**
- 
- 
- 

**Additional Observations:**
- 
- 
- 

**Recommendation:**
- [ ] Deploy immediately
- [ ] Deploy with monitoring
- [ ] Fix issues first, deploy later
- [ ] Rollback

---

## 🎉 SUCCESS CRITERIA

Phase 1 considered SUCCESSFUL if:

1. ✅ Dashboard loads 50% faster than old version
2. ✅ Teachers can search students instantly (< 200ms)
3. ✅ Navigation simplified (3 items instead of 4)
4. ✅ Mobile experience improved (responsive design works)
5. ✅ Zero critical bugs in first 48 hours
6. ✅ Positive teacher feedback (survey > 4/5 stars)

---

**Quick Test Time Estimate:** 50-60 minutes  
**Full Comprehensive Test:** 3-4 hours (see PHASE_1_TESTING_REPORT.md)

---

**Version:** 1.0  
**Last Updated:** [TO BE FILLED]
