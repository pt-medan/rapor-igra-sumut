# 🧪 Manual Testing Guide - BIGINT Overflow Fix

## ✅ Quick Start Testing

**Status:** Application running on http://localhost:8000

### Step 1: Login as Guru
1. Open http://localhost:8000
2. Login credentials:
   - Email: `guru1@example.com` (or any guru account)
   - Password: `password`

### Step 2: Navigate to Kelola Siswa
1. Click menu: **Kelola Siswa**
2. You should see student list page

### Step 3: Test 1 - Add Student (Tests Increment)
1. Click **Tambah Siswa** button
2. Fill form:
   - Nama Lengkap: `Student Test 1`
   - NISN: `12345001`
   - Tempat Lahir: `Jakarta`
   - Tanggal Lahir: `2010-01-01`
   - Jenis Kelamin: `L` or `P`
3. Click **Simpan**
4. **EXPECTED:** ✅ Student added successfully
5. **VERIFY:** Count in student list increased

### Step 4: Test 2 - Delete Student (Tests Decrement)
1. From Kelola Siswa page
2. Find the student you just added
3. Click delete button (trash icon)
4. Confirm deletion
5. **EXPECTED:** ✅ No error! Student deleted successfully
6. **IF ERROR:** Should NOT see:
   ```
   SQLSTATE[22003]: Numeric value out of range: 1690 BIGINT UNSIGNED
   ```

### Step 5: Test 3 - Add Multiple & Delete
1. Add 3 more students with different data:
   - `Student Test 2`, NISN: `12345002`
   - `Student Test 3`, NISN: `12345003`
   - `Student Test 4`, NISN: `12345004`
2. Verify count shows 4 (or 3 if still have 1 from Test 1)
3. Delete 1 student
4. **EXPECTED:** ✅ List updates, count decreases
5. Delete another
6. **EXPECTED:** ✅ Still works correctly
7. Delete last one
8. **EXPECTED:** ✅ Works even when count reaches 0

### Step 6: Database Verification (Optional)
If you want to verify in database directly:

```bash
# Open database CLI
sqlite3 database/database.sqlite

# Query to verify synchronization
SELECT 
    u.name as guru_name,
    g.student_count,
    COUNT(s.id) as actual_students
FROM gurus g
JOIN users u ON g.user_id = u.id
LEFT JOIN siswa s ON g.id = s.guru_id
GROUP BY g.id
ORDER BY g.id;

# Exit
.quit
```

**EXPECTED:** `student_count` should match `actual_students`

## 🔴 Error Conditions to Test

### ❌ THIS SHOULD NOT HAPPEN ANYMORE:
- Delete student → SQLSTATE error about BIGINT overflow
- Delete any student → Any QueryException error

## 📊 Test Results Template

Use this to document your testing:

| Test Case | Status | Notes |
|-----------|--------|-------|
| Add Student 1 | ✅ / ❌ | |
| Delete Student 1 | ✅ / ❌ | |
| Add 3 Students | ✅ / ❌ | |
| Delete Student 1 of 3 | ✅ / ❌ | |
| Delete Student 2 of 3 | ✅ / ❌ | |
| Delete Student 3 of 3 | ✅ / ❌ | |
| Add & Delete Mix | ✅ / ❌ | |

## 🚀 After Successful Testing

1. ✅ All tests pass locally
2. 📝 Document test results
3. 🔄 Ready for production deployment via:
   ```bash
   git pull origin main
   php artisan migrate
   ```

## 💾 Important Database Queries

**Check Current Student Counts:**
```sql
SELECT id, nama_guru, student_count FROM gurus LIMIT 5;
```

**Check Actual Students per Guru:**
```sql
SELECT guru_id, COUNT(*) as total FROM siswas GROUP BY guru_id;
```

**Find Mismatches:**
```sql
SELECT g.id, g.student_count, COUNT(s.id) as actual
FROM gurus g
LEFT JOIN siswas s ON g.id = s.guru_id
GROUP BY g.id
HAVING g.student_count != COUNT(s.id);
-- If this returns rows, there's a mismatch
```

## ⚠️ Troubleshooting

**If you see BIGINT error still:**
1. Hard refresh browser (Cmd+Shift+R on Mac)
2. Check if Laravel has cached code:
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```
3. Verify code was updated:
   ```bash
   git status
   git log --oneline -5
   ```

**If count doesn't change:**
1. Check browser console (F12) for JavaScript errors
2. Check Laravel logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

## 📞 Need Help?

If tests fail or you see unexpected behavior:
1. Take screenshot of error
2. Get error log:
   ```bash
   tail -20 storage/logs/laravel.log
   ```
3. Run database check query
4. Report findings

---

**Fix Commit:** `28b2571` - BIGINT overflow fix with increment and validation
**Date:** November 22, 2025
**Status:** ✅ Code Fixed, Ready for Testing
