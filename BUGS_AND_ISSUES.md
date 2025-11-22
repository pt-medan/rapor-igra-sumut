# 🐛 BUGS & ISSUES FOUND - E-RAPOR IGRA SUMUT

**Date**: November 22, 2025  
**Status**: Identified & Ready to Fix  
**Priority**: Critical, High, Medium, Low  

---

## 📋 SUMMARY

**Total Issues Found**: 8  
**Critical**: 2  
**High**: 3  
**Medium**: 2  
**Low**: 1  

---

## 🔴 CRITICAL ISSUES (FIX IMMEDIATELY)

### **Issue #1: Debug Code & Debug Routes Still in Production** 
**File**: `routes/web.php` (lines 80-142)  
**Severity**: 🔴 CRITICAL  
**Status**: Not Fixed  

**Problem**:
- Three debug routes exposed in production:
  - `/debug/user-check` - Exposes user information
  - `/debug/siswa-check/{siswa_id}` - Exposes student data
  - `/debug/policy-check/{siswa_id}` - Exposes authorization logic
- These routes can be accessed by any authenticated user
- Sensitive data leakage potential

**Impact**:
- Security vulnerability
- Data exposure risk
- Unauthorized information access

**Fix Location**: Remove lines 80-142 from routes/web.php

**Code to Remove**:
```php
// DEBUG ROUTES - Remove after testing
Route::get('/debug/user-check', function () { ... })->middleware('auth');
Route::get('/debug/siswa-check/{siswa_id}', function ($siswa_id) { ... })->middleware('auth');
Route::get('/debug/policy-check/{siswa_id}', function ($siswa_id) { ... })->middleware('auth');
```

---

### **Issue #2: Debug Comments in PenilaianPolicy** 
**File**: `app/Policies/PenilaianPolicy.php` (lines 44, 76, 107, 138)  
**Severity**: 🔴 CRITICAL  
**Status**: Not Fixed  

**Problem**:
- Multiple "Debug info" logging statements left in production code
- `\Log::warning()` calls for every policy check
- Comment says "dapat dihapus setelah testing" (can be deleted after testing)
- Generates excessive log entries

**Impact**:
- Performance degradation from excessive logging
- Log file bloat
- Makes debugging harder to find real issues

**Locations**:
1. Line 44: `PenilaianPolicy::view` method
2. Line 76: `PenilaianPolicy::create` method
3. Line 107: `PenilaianPolicy::update` method
4. Line 138: `PenilaianPolicy::delete` method

**Fix**: Remove all `\Log::warning()` statements and debug comments

---

## 🟠 HIGH PRIORITY ISSUES

### **Issue #3: Username Typo in Backup Script**
**File**: `app/Http/Controllers/SiswaController.php` (line 54) & BACKUP_EXECUTE_NOW.md  
**Severity**: 🟠 HIGH  
**Status**: Typo Exists  

**Problem**:
- Database username inconsistency:
  - `.env` and migration use: `igrasumu_sefri`
  - Backup script uses: `igrasumi_sefri` (typo - missing 'u')
  - Creates confusion and potential backup failures

**Locations**:
- BACKUP_EXECUTE_NOW.md line: `DB_USER="igrasumi_sefri"` (WRONG)
- Should be: `DB_USER="igrasumu_sefri"` (CORRECT)

**Impact**:
- Backup script may fail
- Database credentials confusion
- Future deployment issues

**Fix**: Change all instances of `igrasumi_sefri` to `igrasumu_sefri`

---

### **Issue #4: Missing Validation on Penilaian Semester Field**
**File**: `app/Http/Controllers/PenilaianController.php` (lines 46-50)  
**Severity**: 🟠 HIGH  
**Status**: Partial Validation  

**Problem**:
- Semester validation rules are inconsistent:
  ```php
  'semester' => 'required|in:1,2,Ganjil,Genap',
  ```
- Accepts both numeric (1,2) and text (Ganjil, Genap)
- But database column stores only '1' or '2'
- Creates data inconsistency

**Code Issue**:
```php
'semester' => 'required|in:1,2,Ganjil,Genap', // Accepts 4 values
// But setter only handles 'ganjil' => '1' and 'genap' => '2'
// If user sends '1' directly, it might not be properly handled
```

**Impact**:
- Data inconsistency in database
- Unpredictable semester display
- Export/report issues

**Fix**: Standardize to accept only numeric values (1, 2) in validation

---

### **Issue #5: No Duplicate Check for Penilaian**
**File**: `app/Http/Controllers/PenilaianController.php`  
**Severity**: 🟠 HIGH  
**Status**: Not Implemented  

**Problem**:
- No validation to prevent duplicate penilaian entries
- A guru can create multiple penilaian for same siswa, tahun_ajaran, semester
- Database doesn't have unique constraint

**Scenario**:
1. Guru creates penilaian for Siswa X, Tahun 2025, Semester Ganjil
2. Guru accidentally creates same again
3. System allows duplicate entry
4. Report shows duplicate grades

**Impact**:
- Data duplication
- Incorrect reports/statistics
- Grade tracking confusion

**Fix**: Add unique constraint and validation check

---

## 🟡 MEDIUM PRIORITY ISSUES

### **Issue #6: No Input Sanitization for Ekstrakurikuler**
**File**: `app/Http/Controllers/PenilaianController.php` (line 64-67)  
**Severity**: 🟡 MEDIUM  
**Status**: Minimal Validation  

**Problem**:
```php
'ekstrakurikuler.*.nama' => 'required_with:ekstrakurikuler|string|max:255',
'ekstrakurikuler.*.predikat' => 'required_with:ekstrakurikuler|string|max:255',
```
- Only validates max length, no format checking
- No XSS protection on dynamic fields
- No SQL injection protection

**Impact**:
- Potential XSS vulnerability
- Data quality issues
- Frontend display problems

**Fix**: Add stricter validation rules

---

### **Issue #7: Missing Student Count Synchronization**
**File**: `app/Http/Controllers/SiswaController.php`  
**Severity**: 🟡 MEDIUM  
**Status**: Partial Implementation  

**Problem**:
- `student_count` incremented on create (line 82)
- But NOT decremented on delete
- Creates mismatch with actual student count

**Scenario**:
1. Guru quota = 30
2. Creates 25 students (student_count = 25)
3. Deletes 5 students
4. student_count still = 25 (should be 20)
5. Guru thinks quota is 5 left (should be 10)

**Impact**:
- Incorrect quota tracking
- Prevents guru from adding students
- Database inconsistency

**Fix**: Add decrement logic in delete method

---

## 🔵 LOW PRIORITY ISSUES

### **Issue #8: No Error Handling for Missing Guru Relationship**
**File**: `app/Http/Controllers/SiswaController.php` (line 22-28)  
**Severity**: 🔵 LOW  
**Status**: Basic Error Handling  

**Problem**:
```php
public function index()
{
    $guru = Auth::user()->guru;
    
    if (!$guru) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar sebagai guru.');
    }
    // ...
}
```
- Only checks in index method
- Not checked in other methods (create, store, edit, update)
- Could cause null reference errors

**Impact**:
- Inconsistent error messages
- Potential null pointer exceptions

**Fix**: Add guru validation in all methods using it

---

## ✅ SUMMARY TABLE

| # | Issue | File | Severity | Type | Status |
|---|-------|------|----------|------|--------|
| 1 | Debug routes exposed | routes/web.php | 🔴 CRITICAL | Security | Not Fixed |
| 2 | Debug logging in Policy | app/Policies/PenilaianPolicy.php | 🔴 CRITICAL | Performance | Not Fixed |
| 3 | Username typo (sefri vs sefri) | Multiple files | 🟠 HIGH | Data | Typo |
| 4 | Inconsistent semester validation | PenilaianController.php | 🟠 HIGH | Data | Partial |
| 5 | No duplicate penilaian check | PenilaianController.php | 🟠 HIGH | Logic | Not Implemented |
| 6 | Missing input sanitization | PenilaianController.php | 🟡 MEDIUM | Security | Minimal |
| 7 | Unbalanced student count sync | SiswaController.php | 🟡 MEDIUM | Logic | Partial |
| 8 | No guru validation in all methods | SiswaController.php | 🔵 LOW | Error Handling | Partial |

---

## 🎯 RECOMMENDED FIX ORDER

### **Phase 1: Critical Issues (Today)**
1. ✓ Remove debug routes from production
2. ✓ Remove debug logging from Policy

### **Phase 2: High Priority Issues (This Week)**
3. ✓ Fix username typo (igrasumi → igrasumu)
4. ✓ Fix semester validation consistency
5. ✓ Add duplicate penilaian check

### **Phase 3: Medium Priority Issues (Next Week)**
6. ✓ Add input sanitization for ekstrakurikuler
7. ✓ Fix student count decrement on delete

### **Phase 4: Low Priority Issues (When Ready)**
8. ✓ Add guru validation to all methods

---

## 📝 NOTES

- All issues have been identified in source code
- No production data has been corrupted yet
- Fixes can be applied gradually
- Each fix will be tested before deployment
- All changes will be committed to GitHub

---

**Ready to start fixing?** Let me know which issues to tackle first! 🚀
