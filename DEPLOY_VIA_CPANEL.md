# 🖥️ DEPLOYMENT VIA cPANEL TERMINAL

**Alternative approach if SSH doesn't work**

---

## 📌 SITUATION

SSH connection timeout terjadi. Sementara menunggu JagoanHosting response, kita bisa gunakan **cPanel Terminal** sebagai alternatif untuk deploy.

---

## 🚀 STEP-BY-STEP: DEPLOY VIA cPANEL

### **Step 1: Login to cPanel**

1. **Open browser**
2. **Go to**: https://dream.jagoanhosting.id:2083/
3. **Login:**
   - Username: `igrasumu`
   - Password: `S3fr1f@dhl@n`

### **Step 2: Open Terminal**

1. **In cPanel, look for "Terminal"** (usually in main menu)
2. **Click Terminal**
3. **You'll see**: `igrasumu@dream:~$` prompt

### **Step 3: Navigate to Application Folder**

```bash
cd /public_html
pwd
# Should show: /home/igrasumu/public_html
```

### **Step 4: Backup Current Application** ⚠️ IMPORTANT

```bash
# Create backup of current application
cp -r /public_html /public_html.backup.$(date +%Y%m%d)

# Verify backup created
ls -la /
```

### **Step 5: Clone GitHub Repository**

```bash
# Go to tmp folder
cd /tmp

# Clone the repository
git clone https://github.com/pt-medan/rapor-igra-sumut.git rapor-app

# Go into cloned folder
cd rapor-app

# Verify files exist
ls -la
```

### **Step 6: Copy Code to Production**

```bash
# Copy all files to public_html
cp -r /tmp/rapor-app/* /public_html/

# Verify
ls -la /public_html/
```

### **Step 7: Setup .env File**

```bash
# Go to application folder
cd /public_html

# Copy .env.example to .env
cp .env.example .env

# Edit .env for production
nano .env
```

**Edit these lines in .env:**
```
APP_DEBUG=false
APP_URL=https://igrasumut.com

DB_DATABASE=igrasumu_rapor
DB_USERNAME=igrasumu_sefri
DB_PASSWORD=S3frifadhlan
DB_HOST=localhost
```

**Save file:**
- Press: `Ctrl + O`
- Press: `Enter`
- Press: `Ctrl + X`

### **Step 8: Check if Git & Composer Available**

```bash
# Check Git
git --version

# Check Composer
composer --version

# Check PHP
php --version
```

**All should show version. If not, continue anyway.**

### **Step 9: Install Dependencies**

```bash
cd /public_html

# Install PHP dependencies
composer install --no-dev

# If composer not available, contact hosting
```

### **Step 10: Generate App Key**

```bash
php artisan key:generate
```

### **Step 11: Run Migrations**

```bash
php artisan migrate --force
```

### **Step 12: Seed Website Settings**

```bash
php artisan db:seed --class=WebsiteSettingSeeder --force
```

### **Step 13: Setup Storage Symlink**

```bash
php artisan storage:link
```

### **Step 14: Clear All Caches**

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### **Step 15: Set File Permissions**

```bash
# Set permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chmod -R 775 public/storage/

# Check permissions
ls -la storage/
```

### **Step 16: Test Application**

**Close Terminal, open browser:**
- Go to: https://igrasumut.com
- Verify website loads
- Check logo appears
- Verify no errors

---

## ✅ VERIFICATION CHECKLIST

After deployment via cPanel Terminal:

- [ ] Website accessible at igrasumut.com
- [ ] No 500 errors
- [ ] Logo displays in header
- [ ] Can login
- [ ] Admin Website section accessible
- [ ] Database records visible
- [ ] No errors in browser console

---

## 🐛 TROUBLESHOOTING

### "Permission denied"
```bash
# Fix permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### "Class not found"
```bash
cd /public_html
composer install
```

### "Database error"
```bash
# Check database connection
php artisan tinker
DB::connection()->getPDO();
exit
```

### "500 Error"
```bash
# Check logs
tail -f storage/logs/laravel.log
```

---

## 📋 STEP-BY-STEP COMMANDS (Copy-Paste Ready)

```bash
# 1. Login via cPanel Terminal, then:

cd /public_html

# 2. Backup
cp -r /public_html /public_html.backup.$(date +%Y%m%d)

# 3. Clone
cd /tmp
git clone https://github.com/pt-medan/rapor-igra-sumut.git rapor-app
cp -r rapor-app/* /public_html/

# 4. Setup .env
cd /public_html
cp .env.example .env
nano .env
# Edit database credentials

# 5. Install & Deploy
composer install --no-dev
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=WebsiteSettingSeeder --force
php artisan storage:link
php artisan cache:clear
php artisan config:clear

# 6. Fix permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# 7. Done! Test website
```

---

## 📞 IF SOMETHING GOES WRONG

### Quick Rollback:
```bash
# Restore from backup
rm -rf /public_html/*
cp -r /public_html.backup.YYYYMMDD/* /public_html/
```

### Check Errors:
```bash
# View error logs
tail -f /public_html/storage/logs/laravel.log

# Or via cPanel File Manager:
# Navigate to: public_html/storage/logs/
# Download laravel.log and view
```

---

## 🎯 NEXT PHASE

Once this deployment succeeds:

1. ✅ Application running on igrasumut.com
2. ⏳ Setup SSH properly (when JagoanHosting responds)
3. ⏳ Configure auto-backups
4. ⏳ Regular Git-based deployments

---

## 📌 IMPORTANT NOTES

- cPanel Terminal method works but is **manual**
- SSH is **more efficient** and **automated**
- Use this as **temporary solution**
- Still waiting for SSH to work properly
- Once SSH works, use `./deploy.sh` scripts

---

## ✨ ADVANTAGES OF THIS APPROACH

✅ No SSH needed
✅ cPanel available immediately
✅ Can deploy right now
✅ Same result as SSH deployment
✅ Website goes live today

---

**Ready to deploy?** Follow steps 1-15 above via cPanel Terminal!

Questions? Check terminal output or contact support.

