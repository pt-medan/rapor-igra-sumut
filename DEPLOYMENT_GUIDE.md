# 📋 PANDUAN DEPLOYMENT E-RAPOR IGRA SUMUT

## 🎯 Tujuan
Dokumentasi ini membantu Anda deploy perubahan dari local development ke production server (igrasumut.com) dengan aman.

---

## 📚 TABLE OF CONTENTS
1. [Workflow Deployment](#workflow-deployment)
2. [Setup Awal (One-time)](#setup-awal-one-time)
3. [Proses Deployment Regular](#proses-deployment-regular)
4. [Backup & Recovery](#backup--recovery)
5. [Troubleshooting](#troubleshooting)

---

## 🔄 Workflow Deployment

```
┌─────────────────────────────────────────────────────────────┐
│  LOCAL DEVELOPMENT (Macbook)                                │
│  - Test fitur baru                                          │
│  - Debug dan perbaiki                                       │
│  - git commit -m "Feature description"                      │
│  - git push origin main                                     │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  GITHUB REPOSITORY                                          │
│  https://github.com/YOUR_USERNAME/rapor-igra-sumut         │
│  (Centralized version control)                              │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  PRODUCTION SERVER (JagoanHosting)                          │
│  - git pull origin main                                     │
│  - composer install (jika ada dependency baru)              │
│  - php artisan migrate                                      │
│  - php artisan db:seed --class=WebsiteSettingSeeder         │
│  - php artisan cache:clear                                  │
│  - Test di igrasumut.com                                    │
└─────────────────────────────────────────────────────────────┘
```

---

## 🚀 SETUP AWAL (One-time)

### A. Setup Git di Local (SUDAH DONE ✅)

```bash
git init
git config user.name "Your Name"
git config user.email "your.email@gmail.com"
git add .
git commit -m "Initial commit: E-Rapor IGRA Sumut with branding management system"
```

### B. Create GitHub Repository & Push

**Steps:**

1. **Buka GitHub.com → Buat repository baru:**
   - Name: `rapor-igra-sumut`
   - Public
   - Jangan "Initialize with README"

2. **Di terminal lokal, jalankan:**

```bash
git remote add origin https://github.com/YOUR_USERNAME/rapor-igra-sumut.git
git branch -M main
git push -u origin main
```

**Ganti `YOUR_USERNAME` dengan username GitHub Anda!**

### C. Setup SSH & Git di Production Server

**Dari terminal lokal (bukan SSH):**

```bash
# 1. Connect ke production server via SSH
ssh username@igrasumut.com

# 2. Navigate ke folder aplikasi (tanya hosting Anda dimana folder production)
cd /home/igrasumut/public_html
# atau
cd /var/www/igrasumut.com
# atau yang lainnya sesuai struktur hosting

# 3. Setup git credentials di server
git config --global user.name "Deployment User"
git config --global user.email "deploy@igrasumut.com"

# 4. Generate SSH key untuk GitHub (opsional tapi recommended)
ssh-keygen -t ed25519 -C "deploy@igrasumut.com"
# Press enter untuk semua pertanyaan

# 5. Copy SSH public key
cat ~/.ssh/id_ed25519.pub

# 6. Add SSH key ke GitHub:
#    - Buka GitHub.com → Settings → SSH and GPG keys
#    - New SSH key → Paste content dari step 5
#    - Add SSH key

# 7. Clone repository dengan SSH
git clone git@github.com:YOUR_USERNAME/rapor-igra-sumut.git app-temp

# 8. Backup data production yang ada
cp -r /home/igrasumut/public_html /home/igrasumut/public_html.backup.$(date +%Y%m%d)

# 9. Pindahkan code baru ke production
mv /home/igrasumut/public_html/* /home/igrasumut/public_html.old/
mv app-temp/* /home/igrasumut/public_html/

# 10. Setup .env production
cp /home/igrasumut/public_html.old/.env /home/igrasumut/public_html/.env
# Edit .env untuk production settings jika perlu

# 11. Jalankan migration & seeder
cd /home/igrasumut/public_html
composer install --no-dev
php artisan migrate --force
php artisan db:seed --class=WebsiteSettingSeeder --force
php artisan storage:link
php artisan cache:clear
php artisan config:clear

# 12. Set permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# 13. Done! Test website
exit
```

---

## 📤 PROSES DEPLOYMENT REGULAR

### Setiap Kali Anda Ingin Deploy Fitur Baru:

#### **Step 1: Di Local (Macbook)**

```bash
# 1. Commit perubahan lokal
cd /Users/macbook/Downloads/prod_rapor_igra
git add .
git commit -m "Add: Feature name / Fix: Bug name"

# 2. Push ke GitHub
git push origin main

# 3. Verifikasi di GitHub.com (lihat commit baru)
```

#### **Step 2: Di Production Server**

```bash
# 1. SSH ke server
ssh username@igrasumut.com

# 2. Navigate ke folder aplikasi
cd /home/igrasumut/public_html
# atau sesuai struktur hosting Anda

# 3. BACKUP DATABASE (PENTING!)
mysqldump -u db_user -p db_name > backup_$(date +%Y%m%d_%H%M%S).sql
# Masukkan password database

# 4. Pull code terbaru dari GitHub
git pull origin main

# 5. Jika ada file composer.json yang berubah:
composer install --no-dev

# 6. Jalankan migration (jika ada file migrasi baru)
php artisan migrate --force

# 7. Jalankan seeder jika diperlukan
php artisan db:seed --class=WebsiteSettingSeeder --force

# 8. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 9. Test aplikasi di browser
exit
```

---

## 💾 BACKUP & RECOVERY

### Auto-Backup Script (Opsional tapi Recommended)

Buat file `backup_daily.sh` di server:

```bash
#!/bin/bash

# Configuration
DB_USER="db_user"
DB_PASS="db_password"
DB_NAME="igrasumut_rapor"
BACKUP_DIR="/home/igrasumut/backups"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory jika belum ada
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Compress
gzip $BACKUP_DIR/db_backup_$DATE.sql

# Delete backup yang lebih dari 30 hari lalu
find $BACKUP_DIR -type f -mtime +30 -delete

echo "Backup completed: $BACKUP_DIR/db_backup_$DATE.sql.gz"
```

Setup cron job untuk auto-backup setiap hari jam 2 pagi:

```bash
# Login ke server SSH
ssh username@igrasumut.com

# Edit crontab
crontab -e

# Add line ini:
0 2 * * * /home/igrasumut/backup_daily.sh >> /home/igrasumut/backup.log 2>&1
```

### Manual Backup Procedure

Sebelum deployment, selalu backup:

```bash
# 1. Backup database
mysqldump -u root -p igrasumut_rapor > igrasumut_backup_$(date +%Y%m%d).sql

# 2. Backup uploads/storage
tar -czf storage_backup_$(date +%Y%m%d).tar.gz /home/igrasumut/public_html/storage/

# 3. Download ke lokal
# Gunakan SFTP client atau command:
sftp username@igrasumut.com
cd backups/
mget *.sql
exit
```

### Recovery Procedure (Jika Ada Error)

```bash
ssh username@igrasumut.com
cd /home/igrasumut/public_html

# 1. Revert code ke commit sebelumnya
git revert HEAD
git push origin main

# 2. Atau: Revert ke previous backup
cp /home/igrasumut/public_html.backup.20250122/* /home/igrasumut/public_html/

# 3. Restore database dari backup
mysql -u root -p igrasumut_rapor < igrasumut_backup_20250122.sql

# 4. Clear cache dan restart
php artisan cache:clear
php artisan config:clear

# 5. Test
exit
```

---

## ❓ TROUBLESHOOTING

### Error: "Repository not found"
- ✅ Verifikasi SSH key sudah di-add ke GitHub
- ✅ Gunakan HTTPS jika SSH error: `git clone https://github.com/username/repo.git`

### Error: "Permission denied (publickey)"
- ✅ Check SSH key: `ssh -i ~/.ssh/id_ed25519 -T git@github.com`
- ✅ Tambahkan key ke ssh-agent: `ssh-add ~/.ssh/id_ed25519`

### Error: "migration failed"
- ✅ Check migration file ada di `database/migrations/`
- ✅ Rollback: `php artisan migrate:rollback --force`
- ✅ Check database credentials di `.env`

### Error: "Class not found" setelah deploy
- ✅ Run: `composer install`
- ✅ Clear cache: `php artisan cache:clear`

### Logo/Favicon tidak muncul setelah deploy
- ✅ Check storage symlink: `php artisan storage:link`
- ✅ Check permissions: `chmod -R 775 storage/`
- ✅ Check image exists di: `storage/app/public/website/`

### Database tidak sinkron dengan local
- ✅ Export database production
- ✅ Import ke local: `mysql -u root -p local_db < production_backup.sql`

---

## ✅ DEPLOYMENT CHECKLIST

Sebelum deploy production:

- [ ] Test semua fitur di local
- [ ] `git status` → tidak ada file yang uncommitted
- [ ] `git log` → verify commit message jelas
- [ ] Push ke GitHub
- [ ] Backup production database
- [ ] Backup production folder
- [ ] SSH ke server dan verify
- [ ] `git pull` code terbaru
- [ ] `php artisan migrate --force`
- [ ] `php artisan cache:clear`
- [ ] Test di production website
- [ ] Verify data production masih ada
- [ ] Verify fitur baru berfungsi

---

## 📞 SUPPORT

Jika ada masalah:

1. Check log: `php artisan logs` atau `storage/logs/laravel.log`
2. Check server error: `tail -f /var/log/apache2/error.log`
3. SSH ke server dan troubleshoot

---

**Last Updated:** November 22, 2025
**Version:** 1.0

