# 🚀 Phase 1 Deployment Guide

**Sistem Penilaian Rapor Perkembangan Siswa PAUD**

---

## 📋 Overview

**Phase 1 Scope:**
- Dashboard simplified (500 lines, 50% reduction)
- Enhanced Kelola Siswa page (search, filter, pagination, bulk actions)
- Reusable breadcrumb component
- Navigation menu restructure (removed redundant "Semua Rapor")
- Controller modifications (pagination support, bug fixes)

**Files Changed:**
- ✅ `resources/views/dashboard-simplified.blade.php` (NEW)
- ✅ `resources/views/guru/siswa/index-enhanced.blade.php` (NEW)
- ✅ `resources/views/components/breadcrumb.blade.php` (NEW)
- ✅ `resources/views/layouts/navigation.blade.php` (MODIFIED)
- ✅ `app/Http/Controllers/SiswaController.php` (MODIFIED)

**Deployment Strategy:** Blue-Green Deployment with Feature Toggle

---

## 🎯 Deployment Options

### Option 1: Direct Replacement (Simple, Faster)
Replace old files with new versions directly. Rollback requires git revert.

**Pros:** 
- Fast deployment (5 minutes)
- Clean file structure
- No code duplication

**Cons:** 
- Immediate impact to all users
- Rollback requires code deployment

**Recommended for:** Small user base, low-risk environments

---

### Option 2: Feature Toggle (Safer, Gradual)
Keep both old and new versions, toggle via config. Gradual rollout to % of users.

**Pros:** 
- Can enable for beta testers first
- Instant rollback via config change (no code deployment)
- A/B testing possible

**Cons:** 
- More complex setup
- Code duplication for transition period
- Requires cleanup later

**Recommended for:** Production environments, large user base

---

## 🛠️ PRE-DEPLOYMENT CHECKLIST

### 1. Code Preparation
- [ ] All changes committed to git branch: `phase-1-ui-improvements`
- [ ] Branch merged to `main` or `develop` (if using GitFlow)
- [ ] No uncommitted changes: `git status`
- [ ] Code reviewed by at least 1 team member
- [ ] All tests passed: `php artisan test`

### 2. Database Backup
```bash
# PostgreSQL
pg_dump -U username -h localhost dbname > backup_$(date +%Y%m%d_%H%M%S).sql

# MySQL
mysqldump -u username -p dbname > backup_$(date +%Y%m%d_%H%M%S).sql

# SQLite
cp database/database.sqlite database/database.sqlite.backup
```

### 3. Environment Check
- [ ] Server disk space > 20% free: `df -h`
- [ ] PHP version >= 8.2: `php -v`
- [ ] Laravel version 11.x: `php artisan --version`
- [ ] All dependencies installed: `composer install --no-dev --optimize-autoloader`
- [ ] `.env` file configured correctly (APP_DEBUG=false for production)

### 4. Testing Verification
- [ ] Quick test checklist completed (see PHASE_1_QUICK_TEST_CHECKLIST.md)
- [ ] No critical bugs found
- [ ] Performance benchmarks met (dashboard < 2s, siswa page < 3s)
- [ ] Accessibility audit passed (WCAG 2.1 AA)

---

## 🚀 DEPLOYMENT PROCEDURE

### OPTION 1: Direct Replacement Deployment

#### Step 1: Maintenance Mode (Optional)
```bash
# Enable maintenance mode
php artisan down --message="Updating system, back in 5 minutes" --retry=60

# Check status
curl -I https://your-domain.com
# Should return 503 Service Unavailable
```

#### Step 2: Pull Latest Code
```bash
# Navigate to project directory
cd /path/to/prod_rapor_igra

# Stash any local changes (shouldn't have any)
git stash

# Pull latest code
git pull origin main

# Verify correct commit
git log --oneline -5
```

#### Step 3: Install Dependencies
```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install NPM dependencies (if frontend assets changed)
npm install --production

# Build frontend assets
npm run build
```

#### Step 4: Rename Files to Activate New Views
```bash
# Backup old files
cp resources/views/dashboard.blade.php resources/views/dashboard-OLD.blade.php.backup
cp resources/views/guru/siswa/index.blade.php resources/views/guru/siswa/index-OLD.blade.php.backup

# Activate new files (rename to replace old)
mv resources/views/dashboard-simplified.blade.php resources/views/dashboard.blade.php
mv resources/views/guru/siswa/index-enhanced.blade.php resources/views/guru/siswa/index.blade.php
```

#### Step 5: Clear Caches
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear OPcache (if using)
php artisan opcache:clear  # Or: sudo systemctl restart php-fpm
```

#### Step 6: Run Migrations (If Any)
```bash
# Check migration status
php artisan migrate:status

# Run pending migrations
php artisan migrate --force

# If no migrations, skip this step
```

#### Step 7: Set Permissions
```bash
# Ensure storage and cache are writable
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

#### Step 8: Restart Services
```bash
# Restart PHP-FPM (adjust service name for your OS)
sudo systemctl restart php8.2-fpm

# Restart web server
sudo systemctl restart nginx
# OR
sudo systemctl restart apache2

# Restart queue workers (if using)
sudo supervisorctl restart laravel-worker:*
```

#### Step 9: Disable Maintenance Mode
```bash
# Bring site back online
php artisan up

# Verify site accessible
curl -I https://your-domain.com
# Should return 200 OK
```

#### Step 10: Post-Deployment Verification
```bash
# Check logs for errors
tail -f storage/logs/laravel.log

# Test critical paths
# 1. Login as guru
# 2. Open dashboard
# 3. Navigate to Kelola Siswa
# 4. Test search function
# 5. Test pagination
```

**Deployment Time Estimate:** 10-15 minutes

---

### OPTION 2: Feature Toggle Deployment

#### Step 1: Create Feature Toggle Config
```bash
# Create config/features.php if doesn't exist
cat > config/features.php << 'EOF'
<?php

return [
    'phase1_ui' => env('FEATURE_PHASE1_UI', false),
    'phase1_rollout_percentage' => env('FEATURE_PHASE1_ROLLOUT', 0),
];
EOF
```

#### Step 2: Add Feature Toggle to .env
```bash
# Add to .env file
echo "FEATURE_PHASE1_UI=false" >> .env
echo "FEATURE_PHASE1_ROLLOUT=0" >> .env
```

#### Step 3: Modify Controllers to Use Feature Flag
```php
// app/Http/Controllers/GuruController.php (Dashboard)

public function dashboard()
{
    // Check feature flag
    $useNewUI = config('features.phase1_ui');
    
    // ... existing logic ...
    
    if ($useNewUI) {
        return view('dashboard-simplified', $data);
    }
    
    return view('dashboard', $data);  // Old version
}
```

```php
// app/Http/Controllers/SiswaController.php

public function index(Request $request)
{
    $useNewUI = config('features.phase1_ui');
    
    // ... existing pagination logic ...
    
    if ($useNewUI) {
        return view('guru.siswa.index-enhanced', compact('siswas'));
    }
    
    return view('guru.siswa.index', compact('siswas'));  // Old version
}
```

#### Step 4: Deploy Code (Same as Option 1 Steps 1-8)
Follow Option 1 steps but **skip Step 4** (file renaming).

#### Step 5: Enable Feature for Beta Testers
```bash
# Enable for specific users (requires middleware implementation)
# OR enable for 10% of users
php artisan config:set FEATURE_PHASE1_ROLLOUT=10
php artisan config:cache

# Monitor logs and user feedback for 24-48 hours
tail -f storage/logs/laravel.log
```

#### Step 6: Gradual Rollout
```bash
# Day 1: 10% of users
FEATURE_PHASE1_ROLLOUT=10

# Day 2: 25% of users (if no issues)
FEATURE_PHASE1_ROLLOUT=25

# Day 3: 50% of users
FEATURE_PHASE1_ROLLOUT=50

# Day 4: 100% of users (full rollout)
FEATURE_PHASE1_UI=true
FEATURE_PHASE1_ROLLOUT=100
```

#### Step 7: Cleanup Old Code (After 2 weeks)
```bash
# Remove old view files
rm resources/views/dashboard.blade.php
rm resources/views/guru/siswa/index.blade.php

# Rename new files to standard names
mv resources/views/dashboard-simplified.blade.php resources/views/dashboard.blade.php
mv resources/views/guru/siswa/index-enhanced.blade.php resources/views/guru/siswa/index.blade.php

# Remove feature toggle code from controllers
# Update controllers to always use new views

# Remove feature config
# Remove FEATURE_PHASE1_* from .env

# Commit cleanup
git add .
git commit -m "chore: Remove Phase 1 feature toggle, cleanup old code"
git push origin main
```

**Deployment Time Estimate:** 20-30 minutes (initial), 2 weeks (gradual rollout)

---

## 🔙 ROLLBACK PROCEDURE

### Quick Rollback (Feature Toggle - Instant)
```bash
# Edit .env file
nano .env

# Change feature flag
FEATURE_PHASE1_UI=false
FEATURE_PHASE1_ROLLOUT=0

# Clear config cache
php artisan config:clear
php artisan config:cache

# Verify old UI restored
curl https://your-domain.com/dashboard
```

**Rollback Time:** 30 seconds ⚡

---

### Full Rollback (Direct Replacement - 5 minutes)

#### Step 1: Identify Previous Commit
```bash
cd /path/to/prod_rapor_igra

# View recent commits
git log --oneline -10

# Example output:
# abc1234 feat(phase1): Complete navigation restructure
# def5678 feat(phase1): Enhanced Kelola Siswa page
# ghi9012 fix: Remove Siswa user relation bug
# jkl3456 (rollback to this) feat: Add pagination to dashboard

# Note the commit hash BEFORE Phase 1 changes
```

#### Step 2: Create Rollback Branch
```bash
# Create rollback branch from previous commit
git checkout -b rollback-phase1 jkl3456

# Verify correct version
git log --oneline -3
```

#### Step 3: Deploy Rollback
```bash
# Enable maintenance mode
php artisan down --message="Rolling back update" --retry=60

# Checkout rollback branch
git checkout rollback-phase1

# Or directly checkout previous commit
git checkout jkl3456

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

# Disable maintenance mode
php artisan up
```

#### Step 4: Verify Rollback Success
```bash
# Test old version loads
curl https://your-domain.com/dashboard

# Check logs for errors
tail -f storage/logs/laravel.log

# Test critical functionality:
# - Login
# - Dashboard displays old layout
# - Kelola Siswa displays old table
# - Navigation shows "Semua Rapor" link again
```

#### Step 5: Database Rollback (If Migrations Ran)
```bash
# Check current migration state
php artisan migrate:status

# Rollback last batch of migrations
php artisan migrate:rollback --step=1

# Verify tables correct
php artisan tinker
# >>> \Schema::hasColumn('siswas', 'new_column_name')
# => false  (good, column removed)
```

**Full Rollback Time:** 5-10 minutes

---

## 🚨 EMERGENCY PROCEDURES

### Critical Bug Found After Deployment

**Symptoms:**
- 500 Internal Server Error on dashboard
- Users cannot login
- Database errors in logs
- All pages blank/broken

**Immediate Action:**
```bash
# 1. Enable maintenance mode FIRST
php artisan down --message="Fixing critical issue"

# 2. Quick rollback (Option 1 or 2 above)
# Follow rollback procedure

# 3. Restore database from backup (if needed)
psql -U username -d dbname < backup_20250128_120000.sql

# 4. Clear all caches
php artisan cache:clear && php artisan config:clear && php artisan view:clear

# 5. Restart services
sudo systemctl restart php8.2-fpm nginx

# 6. Verify site restored
curl https://your-domain.com

# 7. Disable maintenance mode
php artisan up

# 8. Notify users via email/SMS (if downtime > 30 min)
```

### Site Down / No Response

**Symptoms:**
- Site not loading at all
- Nginx/Apache not responding
- 502 Bad Gateway

**Troubleshooting:**
```bash
# Check web server status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check disk space
df -h
# If < 5% free, clear logs:
# sudo find /var/log -type f -name "*.log" -mtime +30 -delete

# Check error logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f storage/logs/laravel.log

# Restart services
sudo systemctl restart php8.2-fpm nginx

# Check database connection
php artisan tinker
# >>> DB::connection()->getPdo();
```

---

## 📊 POST-DEPLOYMENT MONITORING

### First 24 Hours
- [ ] Check error logs every 2 hours: `tail -f storage/logs/laravel.log`
- [ ] Monitor server resources: `htop` or monitoring dashboard
- [ ] Check application performance: Google Analytics, Laravel Telescope
- [ ] Gather user feedback: email survey, in-app feedback widget
- [ ] Monitor support tickets: check for bug reports

### First Week
- [ ] Review Google Analytics for page load times
- [ ] Check query performance: Laravel Debugbar, New Relic
- [ ] Analyze user behavior: heatmaps, session recordings
- [ ] Collect teacher feedback: survey (target 50+ responses)
- [ ] Fix minor bugs found (non-critical)

### Success Metrics
- **Performance:** Dashboard load time reduced by 30%+
- **User Satisfaction:** Survey rating > 4/5 stars
- **Adoption:** 90%+ teachers use new search feature
- **Stability:** Zero critical bugs in first week
- **Support:** < 5 support tickets per 100 users

---

## 📝 COMMUNICATION PLAN

### Before Deployment (3 days notice)
**Email to All Teachers:**
```
Subject: Sistem Rapor Update - Peningkatan Fitur Baru

Yth. Bapak/Ibu Guru,

Kami akan melakukan pembaruan sistem rapor pada:
📅 Tanggal: [DATE]
⏰ Waktu: [TIME] (estimasi 15 menit downtime)

Fitur Baru:
✅ Dashboard lebih cepat dan sederhana
✅ Pencarian siswa instant (tidak perlu refresh)
✅ Filter dan pagination lebih baik
✅ Navigasi menu lebih simpel

Video Tutorial: [LINK]
Panduan PDF: [LINK]

Terima kasih,
Tim IT
```

### During Deployment
**Status Page Update:**
```
🔧 Sistem sedang diupdate
Estimasi selesai: [TIME]
Status: [Progress Bar]
```

### After Deployment (Success)
**Email Confirmation:**
```
Subject: ✅ Update Selesai - Sistem Rapor Sudah Aktif

Update berhasil! Sistem sudah bisa digunakan kembali.

Apa yang baru:
- Dashboard 50% lebih cepat
- Pencarian siswa instant
- Menu navigasi lebih simpel

Butuh bantuan? Hub: [CONTACT]
```

### After Deployment (If Issues)
**Email Notification:**
```
Subject: ⚠️ Pemberitahuan Masalah Teknis

Kami mengalami kendala teknis setelah update.
Status: Rollback sedang dilakukan
Estimasi normal: [TIME]

Update akan dijadwalkan ulang.
Mohon maaf atas ketidaknyamanannya.
```

---

## ✅ DEPLOYMENT SIGN-OFF

**Pre-Deployment Approval:**
- [ ] Developer: _____________ Date: _______
- [ ] QA/Tester: _____________ Date: _______
- [ ] Project Manager: _____________ Date: _______
- [ ] System Admin: _____________ Date: _______

**Post-Deployment Verification:**
- [ ] Deployment Successful: YES / NO
- [ ] All Tests Passed: YES / NO
- [ ] User Notification Sent: YES / NO
- [ ] Monitoring Active: YES / NO

**Deployment Date/Time:** _______________  
**Deployment Duration:** _____ minutes  
**Downtime:** _____ minutes  
**Issues Encountered:** _______________  
**Rollback Required:** YES / NO  

---

## 📚 REFERENCES

- Phase 1 Testing Report: `PHASE_1_TESTING_REPORT.md`
- Quick Test Checklist: `PHASE_1_QUICK_TEST_CHECKLIST.md`
- Git Commit History: `git log --oneline --graph`
- Laravel Deployment Docs: https://laravel.com/docs/11.x/deployment

---

**Document Version:** 1.0  
**Last Updated:** [TO BE COMPLETED]  
**Author:** GitHub Copilot & Development Team
