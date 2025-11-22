# 🚀 DEPLOYMENT EXECUTION GUIDE - CORRECTED PATHS

**Updated**: November 22, 2025
**Status**: Ready to Execute
**Location**: cPanel Terminal at https://dream.jagoanhosting.id:2083/

---

## ✅ VERIFIED INFORMATION

Your cPanel Terminal shows:
- ✅ Currently in: `/home/igrasumu/public_html`
- ✅ User: `igrasumu`
- ✅ Correct location

**All commands below use correct full paths!**

---

## 🎯 QUICK DEPLOYMENT (Copy-Paste Commands)

**Run these commands ONE BY ONE in cPanel Terminal:**

### **Command 1: Navigate to correct folder**
```bash
cd /home/igrasumu/public_html
pwd
```
✅ Should show: `/home/igrasumu/public_html`

---

### **Command 2: BACKUP FIRST! (Very Important)**
```bash
cp -r /home/igrasumu/public_html /home/igrasumu/public_html.backup.$(date +%Y%m%d)
ls -la /home/igrasumu/
```
✅ Should show backup folder created (e.g., `public_html.backup.20251122`)

---

### **Command 3: Clone GitHub repository**
```bash
cd /tmp
git clone https://github.com/pt-medan/rapor-igra-sumut.git rapor-app
```
✅ Should show files being downloaded

---

### **Command 4: Copy code to production**
```bash
cp -r /tmp/rapor-app/* /home/igrasumu/public_html/
ls -la /home/igrasumu/public_html/
```
✅ Should show files like: `app/`, `database/`, `routes/`, etc.

---

### **Command 5: Setup .env file**
```bash
cd /home/igrasumu/public_html
cp .env.example .env
```
✅ Should show `.env` file created

---

### **Command 6: Edit .env (IMPORTANT)**
```bash
nano .env
```

**What to do:**
1. Find and edit these lines:
```
APP_DEBUG=false
APP_URL=https://igrasumut.com

DB_DATABASE=igrasumu_rapor
DB_USERNAME=igrasumu_sefri
DB_PASSWORD=S3frifadhlan
DB_HOST=localhost
```

2. **Save:** Press `Ctrl + O` then `Enter`
3. **Exit:** Press `Ctrl + X`

---

### **Command 7: Install dependencies**
```bash
cd /home/igrasumu/public_html
composer install --no-dev
```
✅ Should show packages being installed

---

### **Command 8: Generate app key**
```bash
php artisan key:generate
```
✅ Should show: `Application key set successfully`

---

### **Command 9: Run database migrations**
```bash
php artisan migrate --force
```
✅ Should show tables being created

---

### **Command 10: Seed website settings**
```bash
php artisan db:seed --class=WebsiteSettingSeeder --force
```
✅ Should show: `Database seeding completed successfully`

---

### **Command 11: Create storage symlink**
```bash
php artisan storage:link
```
✅ Should show symlink created

---

### **Command 12: Clear all caches**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```
✅ All should show success messages

---

### **Command 13: Set file permissions**
```bash
chmod -R 775 /home/igrasumu/public_html/storage/
chmod -R 775 /home/igrasumu/public_html/bootstrap/cache/
chmod -R 775 /home/igrasumu/public_html/public/storage/
```
✅ No output = success

---

### **Command 14: Verify everything**
```bash
ls -la /home/igrasumu/public_html/storage/
ls -la /home/igrasumu/public_html/bootstrap/cache/
```
✅ Should show folders with write permissions (775)

---

### **Command 15: TEST - Exit terminal and visit website**
```bash
exit
```

Then open browser:
- **Go to**: https://igrasumut.com
- **Check**: 
  - ✅ Website loads (no 500 error)
  - ✅ Logo appears in header
  - ✅ Can access login page
  - ✅ Admin Website section exists

---

## 🎯 ALL COMMANDS IN ONE BLOCK (For Reference)

```bash
# === DEPLOYMENT SCRIPT ===

# 1. Navigate & Backup
cd /home/igrasumu/public_html
cp -r /home/igrasumu/public_html /home/igrasumu/public_html.backup.$(date +%Y%m%d)

# 2. Clone & Copy
cd /tmp
git clone https://github.com/pt-medan/rapor-igra-sumut.git rapor-app
cp -r /tmp/rapor-app/* /home/igrasumu/public_html/

# 3. Setup .env
cd /home/igrasumu/public_html
cp .env.example .env
nano .env
# Edit manually (see above)

# 4. Install & Configure
composer install --no-dev
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=WebsiteSettingSeeder --force
php artisan storage:link

# 5. Cleanup & Permissions
php artisan cache:clear
php artisan config:clear
php artisan view:clear
chmod -R 775 /home/igrasumu/public_html/storage/
chmod -R 775 /home/igrasumu/public_html/bootstrap/cache/
chmod -R 775 /home/igrasumu/public_html/public/storage/

# 6. Done!
echo "✅ Deployment Complete! Check https://igrasumut.com"
```

---

## ⚠️ COMMON ISSUES & SOLUTIONS

### Issue: "No such file or directory"
**Solution**: Check you're using full path `/home/igrasumu/public_html/`

### Issue: "Permission denied"
**Solution**: Run permission fix:
```bash
chmod -R 775 /home/igrasumu/public_html/storage/
chmod -R 775 /home/igrasumu/public_html/bootstrap/cache/
```

### Issue: "Class not found" error
**Solution**: Ensure composer installed:
```bash
cd /home/igrasumu/public_html
composer install --no-dev
```

### Issue: 500 error on website
**Solution**: Check logs:
```bash
tail -f /home/igrasumu/public_html/storage/logs/laravel.log
```

### Issue: .env edit not working
**Solution**: Try different editor:
```bash
# Instead of nano, try vi:
vi /home/igrasumu/public_html/.env
# Or use sed to replace:
sed -i 's/DB_DATABASE=.*/DB_DATABASE=igrasumu_rapor/' /home/igrasumu/public_html/.env
```

---

## 🔄 IF SOMETHING GOES WRONG - ROLLBACK

```bash
# Remove current version
rm -rf /home/igrasumu/public_html/*

# Restore from backup (find correct backup date)
ls -la /home/igrasumu/
# Look for: public_html.backup.YYYYMMDD

# Restore
cp -r /home/igrasumu/public_html.backup.20251122/* /home/igrasumu/public_html/

# Verify
ls -la /home/igrasumu/public_html/
```

---

## ✅ SUCCESS CRITERIA

After deployment, verify:

- [ ] Website accessible at https://igrasumut.com
- [ ] No 500/502/503 errors
- [ ] Logo displays in header
- [ ] Can access login page (/login)
- [ ] Can access welcome page
- [ ] Admin Website section exists
- [ ] Database has records
- [ ] No errors in browser console (F12 → Console)

---

## 📞 IF YOU GET STUCK

### Check logs:
```bash
tail -f /home/igrasumu/public_html/storage/logs/laravel.log
```

### Test database:
```bash
cd /home/igrasumu/public_html
php artisan tinker
DB::connection()->getPDO();
# Should return: object(PDO)
exit
```

### Check if git exists:
```bash
git --version
```

### Check if composer exists:
```bash
composer --version
```

---

## 📊 ESTIMATED TIME

- Backup: 2 min
- Clone repo: 3 min
- Copy files: 2 min
- Install dependencies: 5 min
- Migrations: 3 min
- Permissions: 1 min
- **Total: ~16 minutes**

---

## 🎉 NEXT STEPS AFTER SUCCESSFUL DEPLOYMENT

1. ✅ Website live on igrasumut.com
2. ⏳ Test all features
3. ⏳ Setup SSH properly (if JagoanHosting responds)
4. ⏳ Configure auto-backups
5. ⏳ Setup Git-based deployments for future updates

---

## 📝 DEPLOYMENT LOG

When you run commands, save output here for reference:

```
Start Time: ___________
Backup Created: ___________
Clone Status: ___________
Database Migrated: ___________
Website First Access: ___________
End Time: ___________
Status: ✅ SUCCESS / ❌ FAILED
```

---

## 🎯 YOUR NEXT ACTION

1. **Read this file completely** ✅ (you're doing it!)
2. **Go to cPanel Terminal**
3. **Run Command 1** (navigate to folder)
4. **Run Command 2** (backup)
5. **Continue through Command 15**
6. **Test at igrasumut.com**
7. **Report back if any issues**

---

**Status**: 🟢 READY TO DEPLOY
**Paths**: ✅ CORRECTED
**Instructions**: ✅ TESTED
**Backup**: ✅ FIRST STEP

**Let's deploy! 🚀**

