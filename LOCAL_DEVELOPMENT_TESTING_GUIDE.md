# 🚀 LOCAL DEVELOPMENT & TESTING SETUP GUIDE

**Status:** Development Mode - Comprehensive Testing
**Environment:** Local Development (localhost:8000)
**Objective:** Complete application testing before production deployment

---

## ✅ QUICK START - VERIFY EVERYTHING IS RUNNING

### Check 1: Laravel Server Status
```bash
# Terminal 1 should show:
# lsof -i :8000
# PHP server listening on port 8000
```

**Verify:** http://localhost:8000 should load the login page

### Check 2: Database Status
```bash
# Terminal should show:
# Database is: database/database.sqlite
# Can run queries via: sqlite3 database/database.sqlite
```

**Test Database Connection:**
```bash
sqlite3 database/database.sqlite ".tables"
# Should show: cache_locks, failed_jobs, gurus, jobs, kelompok_kelas, migrations, password_resets, penilaians, sekolahs, siswas, users, etc.
```

### Check 3: Node/Vite Status
```bash
# Terminal 2 should show:
# npm run dev
# Vite running and compiling assets
```

**Verify:** Browser should load styles correctly (no unstyled page)

---

## 🧪 PHASE 1: AUTHENTICATION & AUTHORIZATION (30 minutes)

### Available Test Accounts

Check `database/seeders/` to see what accounts exist. Default typically:

```
Admin Account:
  Email: admin@example.com
  Password: password

Guru Account:
  Email: guru1@example.com
  Password: password

Guru 2 Account:
  Email: guru2@example.com
  Password: password
```

If accounts don't exist, run seeder:
```bash
php artisan db:seed
```

### Test 1.1: Admin Login
1. Open http://localhost:8000
2. Enter admin@example.com / password
3. Click Login
4. **Expected:** ✅ Dashboard loads, admin menu visible
5. **Record:** [ ] PASS  [ ] FAIL

### Test 1.2: Guru Login
1. Logout (if logged in)
2. Enter guru1@example.com / password
3. Click Login
4. **Expected:** ✅ Guru dashboard loads, guru menu visible (NOT admin)
5. **Record:** [ ] PASS  [ ] FAIL

### Test 1.3: Permission Check
1. While logged in as guru1
2. Try to access: http://localhost:8000/admin/users
3. **Expected:** ❌ 403 Forbidden or redirect
4. **Record:** [ ] PASS  [ ] FAIL

### Test 1.4: Logout
1. Click logout button
2. **Expected:** ✅ Redirected to login page
3. **Try accessing admin page:** Should redirect to login
4. **Record:** [ ] PASS  [ ] FAIL

---

## 📚 PHASE 2: STUDENT MANAGEMENT (45 minutes)

### Test 2.1: View Student List
1. Login as guru1
2. Click "Kelola Siswa" menu
3. **Check:**
   - [ ] Page loads without errors
   - [ ] Student list displays (if any students exist)
   - [ ] Columns show: No, Nama, NISN, Kelas, Actions
   - [ ] No console errors (F12 → Console)
4. **Record:** [ ] PASS  [ ] FAIL

### Test 2.2: Add Student
1. Click "Tambah Siswa" button
2. Fill form:
   - Nama Lengkap: **Test Student One**
   - NISN: **123450001**
   - Tempat Lahir: **Jakarta**
   - Tanggal Lahir: **2010-01-15**
   - Jenis Kelamin: **L**
3. Click "Simpan"
4. **Expected:**
   - [ ] Success message shows
   - [ ] Redirected to student list
   - [ ] Student appears in list
5. **Record:** [ ] PASS  [ ] FAIL

**If Failed:** Check `storage/logs/laravel.log` for error

### Test 2.3: Add Another Student
Repeat Test 2.2 with different data:
- Nama: **Test Student Two**
- NISN: **123450002**
- Other fields: any value

**Purpose:** Verify multiple students can be added

### Test 2.4: View Student Details
1. Click on a student name in the list
2. **Expected:**
   - [ ] Student details page loads
   - [ ] All fields display correctly
   - [ ] Shows grades if exist (Penilaian)
   - [ ] Edit and Delete buttons visible
3. **Record:** [ ] PASS  [ ] FAIL

### Test 2.5: Edit Student
1. From student list, click edit button (pencil icon)
2. Change name: **Test Student One Updated**
3. Click "Simpan"
4. **Expected:**
   - [ ] Success message
   - [ ] Name updated in list
   - [ ] Details show updated name
5. **Record:** [ ] PASS  [ ] FAIL

### Test 2.6: Delete Student (Test Bug #9 Fix!)
1. From student list, click delete button (trash icon)
2. Confirm deletion
3. **Expected:**
   - [ ] ✅ **NO ERROR** (Bug #9 should be fixed!)
   - [ ] Student removed from list
   - [ ] Page still responsive
   - [ ] Check logs - no SQLSTATE errors
4. **Record:** [ ] PASS  [ ] FAIL

**⚠️ Important:** If you see `SQLSTATE[22003]` error, Bug #9 is NOT fixed properly!

### Test 2.7: Duplicate NISN Prevention
1. Try to add student with NISN **123450001** (already exists from Test 2.2)
2. **Expected:**
   - [ ] Error message: "NISN already exists" or similar
   - [ ] Form not submitted
3. **Record:** [ ] PASS  [ ] FAIL

---

## 📊 PHASE 3: GRADES/PENILAIAN (45 minutes)

### Test 3.1: View Penilaian List
1. Click "Penilaian" menu (or Nilai)
2. **Expected:**
   - [ ] Page loads
   - [ ] List displays (empty or with data)
   - [ ] Add button visible
   - [ ] Search/filter visible (if implemented)
3. **Record:** [ ] PASS  [ ] FAIL

### Test 3.2: Add Penilaian
1. Click "Tambah Penilaian" button
2. Fill form:
   - Student: Select **Test Student One** (or any student)
   - Tahun Ajaran: **2024-2025**
   - Semester: **1**
   - All grade fields: Enter values (0-100)
3. Click Submit
4. **Expected:**
   - [ ] Success message
   - [ ] Penilaian appears in list
   - [ ] All values saved correctly
5. **Record:** [ ] PASS  [ ] FAIL

### Test 3.3: Verify Semester Validation (Bug #4 Fix)
1. Try to add another penilaian
2. On the Semester field:
   - [ ] Should show only numeric: 1, 2
   - [ ] Should NOT show: Ganjil, Genap, or text
3. **Record:** [ ] PASS  [ ] FAIL

### Test 3.4: Prevent Duplicate Penilaian (Bug #5 Fix)
1. Try to add penilaian with SAME:
   - Student: Same as Test 3.2
   - Tahun Ajaran: 2024-2025
   - Semester: 1
2. **Expected:**
   - [ ] Error message prevents duplicate
   - [ ] Form not submitted
3. **Record:** [ ] PASS  [ ] FAIL

### Test 3.5: Edit Penilaian
1. From penilaian list, edit an entry
2. Change a grade value
3. Save
4. **Expected:**
   - [ ] Success message
   - [ ] Value updated in list
5. **Record:** [ ] PASS  [ ] FAIL

### Test 3.6: Delete Penilaian
1. Delete a penilaian entry
2. Confirm
3. **Expected:**
   - [ ] No error
   - [ ] Entry removed from list
4. **Record:** [ ] PASS  [ ] FAIL

---

## 🔒 PHASE 4: SECURITY CHECKS (20 minutes)

### Test 4.1: No Debug Routes (Bug #1 Fix)
Run in terminal:
```bash
curl http://localhost:8000/debug/user-check
```

**Expected:** [ ] 404 Not Found or 403 Forbidden (NOT data dump)

**Or in browser:** Try to access http://localhost:8000/debug/user-check  
**Expected:** Error page, NOT debug information

### Test 4.2: Check Laravel Logs
```bash
tail -20 storage/logs/laravel.log
```

**Check:**
- [ ] No excessive warnings
- [ ] No debug \Log::warning() messages (Bug #2 fix)
- [ ] No sensitive data visible

### Test 4.3: Security Headers
Open browser DevTools (F12) → Network tab → Reload page → Click on any request

**Check response headers:**
- [ ] CSRF token present in forms (@csrf)
- [ ] No SQL in error messages
- [ ] No path information leaked

### Test 4.4: Input Sanitization (Bug #6 Fix)
1. Try to add student with special characters:
   - Name: **Test' OR '1'='1**
   - Should NOT execute SQL injection
2. **Expected:** [ ] Stored as plain text, displayed correctly

---

## ✅ PHASE 5: BUG VERIFICATION (15 minutes)

**All 9 Bugs Should Be Fixed:**

- [ ] **Bug #1:** No debug routes → Access /debug/* → 404
- [ ] **Bug #2:** No debug logging → Check laravel.log → clean
- [ ] **Bug #3:** Username correct → Check backup script → igrasumu_sefri
- [ ] **Bug #4:** Semester numeric → Add penilaian → only 1, 2
- [ ] **Bug #5:** No duplicate → Add same penilaian → error
- [ ] **Bug #6:** Input safe → Special chars → stored safely
- [ ] **Bug #7:** Count syncs → Delete student → count OK
- [ ] **Bug #8:** Guru auth → Try access other guru's students → 403
- [ ] **Bug #9:** BIGINT OK → Delete student → NO SQLSTATE error

---

## 🎯 INTEGRATION TEST (30 minutes)

**Complete End-to-End Workflow:**

1. [ ] Login as guru1
2. [ ] Go to Kelola Siswa
3. [ ] Add student "Integration Test Student"
4. [ ] Go to Penilaian
5. [ ] Add grade for that student
6. [ ] View student details → verify grade shows
7. [ ] Edit the grade
8. [ ] Edit the student name
9. [ ] Delete the grade
10. [ ] Delete the student
11. [ ] All steps succeed with no errors

**Result:** [ ] ALL PASS  [ ] SOME ISSUES  [ ] MAJOR ISSUES

---

## 📝 DAILY TESTING CHECKLIST

Use this EVERY time you test:

```
═══════════════════════════════════════════════════════════════════
LOCAL DEVELOPMENT DAILY CHECKLIST
═══════════════════════════════════════════════════════════════════

Date: ______________
Time: ______________

PRE-TEST VERIFICATION:
  [ ] Laravel server running (port 8000)
  [ ] npm run dev running (Vite compiling)
  [ ] Database accessible (sqlite3)
  [ ] Browser cache cleared

TEST RESULTS:
  Phase 1 (Auth):           [ ] PASS  [ ] FAIL  Notes: _______
  Phase 2 (Students):       [ ] PASS  [ ] FAIL  Notes: _______
  Phase 3 (Penilaian):      [ ] PASS  [ ] FAIL  Notes: _______
  Phase 4 (Security):       [ ] PASS  [ ] FAIL  Notes: _______
  Phase 5 (Bug Verify):     [ ] PASS  [ ] FAIL  Notes: _______
  Integration Test:         [ ] PASS  [ ] FAIL  Notes: _______

ISSUES FOUND:
  [ ] None
  [ ] List issues below:
    1. ___________________________
    2. ___________________________
    3. ___________________________

FIXES APPLIED:
  [ ] None needed
  [ ] List fixes below:
    1. ___________________________
    2. ___________________________

LOG REVIEW:
  [ ] No errors in laravel.log
  [ ] No SQLSTATE errors
  [ ] No debug messages

NOTES:
_________________________________________________________________
_________________________________________________________________

OVERALL STATUS: [ ] READY FOR DEPLOYMENT  [ ] NEEDS MORE TESTING

═══════════════════════════════════════════════════════════════════
```

---

## 🐛 HOW TO DEBUG IF TESTS FAIL

### 1. Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
# Watch for errors in real-time as you test
```

### 2. Check Browser Console
- Press F12
- Go to "Console" tab
- Look for red errors
- Check "Network" tab for failed requests

### 3. Check Database
```bash
sqlite3 database/database.sqlite

# Common queries:
SELECT COUNT(*) FROM siswas;
SELECT * FROM siswas LIMIT 5;
SELECT * FROM gurus WHERE id = 1;
SELECT * FROM penilaians LIMIT 5;

# Check for data integrity:
SELECT g.id, g.student_count, COUNT(s.id) as actual
FROM gurus g LEFT JOIN siswas s ON g.id = s.guru_id
GROUP BY g.id;
```

### 4. Clear Cache & Try Again
```bash
php artisan cache:clear
php artisan view:clear
# Restart PHP server and refresh browser
```

### 5. Create GitHub Issue
If you find a bug:
1. Document the exact steps
2. Note the error message
3. Screenshot the error
4. Create a new issue file in docs

---

## ✨ READY TO START TESTING?

### Start Here:
1. ✅ Verify Laravel is running: `http://localhost:8000`
2. ✅ Use `COMPREHENSIVE_TESTING_PLAN.md` for full checklist
3. ✅ Use this file for quick reference
4. ✅ Document results as you go
5. ✅ Report any issues found

---

**Development Mode Active**  
**Environment:** Local (localhost:8000)  
**Status:** Ready for comprehensive testing  
**Next:** Begin Phase 1 testing  
**Goal:** Complete all 5 phases, then decide on production deployment

Good luck with testing! 🚀
