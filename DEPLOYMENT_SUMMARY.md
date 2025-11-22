# 🎯 RINGKASAN STRATEGI DEPLOYMENT & BACKUP

## Status Saat Ini

### ✅ Yang Sudah Selesai:

1. **Git Repository (Local)**
   - Project sudah di-initialize dengan git
   - Semua file sudah di-commit
   - Ready untuk push ke GitHub

2. **Documentation Created**
   - `DEPLOYMENT_GUIDE.md` - Panduan lengkap
   - `QUICK_START.md` - Checklist praktis
   - `deploy.sh` - Automated deployment script
   - `backup_daily.sh` - Auto backup script

3. **Code Ready for Production**
   - Fitur branding management selesai
   - Logo + Favicon management selesai
   - Website settings selesai

---

## 🚀 NEXT STEPS - Action Items

### **STEP 1: Setup GitHub (5 menit)**
- [ ] Buka GitHub.com & login
- [ ] Buat repository baru: `rapor-igra-sumut` (Public)
- [ ] Copy SSH/HTTPS URL
- [ ] Di terminal lokal, run:
  ```bash
  cd /Users/macbook/Downloads/prod_rapor_igra
  git remote add origin https://github.com/YOUR_USERNAME/rapor-igra-sumut.git
  git branch -M main
  git push -u origin main
  ```
- [ ] Verifikasi di GitHub.com bahwa semua file sudah terupload

### **STEP 2: Setup SSH Access ke Hosting (10 menit)**
- [ ] Tanya JagoanHosting:
  - [ ] Alamat SSH server (host)
  - [ ] SSH username
  - [ ] SSH password
  - [ ] Lokasi folder aplikasi (document root)
  - [ ] Database credentials
  
- [ ] Test SSH dari terminal:
  ```bash
  ssh username@host.example.com
  # Jika berhasil, keluar dengan: exit
  ```

### **STEP 3: Clone Repository di Server (5 menit)**
- [ ] SSH ke server:
  ```bash
  ssh username@server
  ```

- [ ] Navigate ke backup folder dan clone:
  ```bash
  cd /tmp
  git clone https://github.com/YOUR_USERNAME/rapor-igra-sumut.git
  ```

- [ ] Backup aplikasi production lama:
  ```bash
  cd /home/igrasumut/public_html  # atau sesuai struktur
  cp -r . backup_20250122/
  ```

- [ ] Pindahkan file baru:
  ```bash
  cp -r /tmp/rapor-igra-sumut/* ./
  ```

### **STEP 4: Configure Production Environment (5 menit)**
- [ ] Edit `.env` di production:
  ```bash
  nano .env
  # Update database credentials sesuai production
  DB_HOST=localhost
  DB_DATABASE=igrasumut_rapor
  DB_USERNAME=db_user
  DB_PASSWORD=db_pass
  ```

- [ ] Buat storage symlink:
  ```bash
  php artisan storage:link
  ```

### **STEP 5: Run First Deployment (5 menit)**
- [ ] Jalankan deployment script:
  ```bash
  chmod +x deploy.sh
  ./deploy.sh
  ```

- [ ] Script akan:
  - ✅ Backup database
  - ✅ Install dependencies
  - ✅ Run migrations
  - ✅ Seed website settings
  - ✅ Clear caches
  - ✅ Set permissions

### **STEP 6: Setup Auto-Backup (3 menit)**
- [ ] SSH ke server
- [ ] Edit crontab:
  ```bash
  crontab -e
  # Add line:
  0 2 * * * /var/www/igrasumut.com/backup_daily.sh
  ```

- [ ] Save (Ctrl+O, Enter, Ctrl+X untuk nano editor)

### **STEP 7: Test Production**
- [ ] Buka igrasumut.com di browser
- [ ] Login sebagai admin
- [ ] Check logo & favicon muncul
- [ ] Test fitur admin website (edit branding)
- [ ] Verifikasi perubahan disimpan di database

---

## 📊 Comparison: Local vs Production Database

### ⚠️ PENTING:
Jangan langsung copy database production ke local (data orang lain)!

### Opsi yang lebih aman:

**Opsi A: Sync dari Production ke Local (RECOMMENDED)**
```bash
# 1. Di server production, backup database:
mysqldump -u root -p igrasumut_rapor > db_export.sql
# Download via SFTP ke lokal

# 2. Di lokal, import:
mysql -u root -p igrasumut_rapor_prod < db_export.sql

# 3. Update .env untuk test production data
DB_DATABASE=igrasumut_rapor_prod
```

**Opsi B: Tetap Terpisah (Lebih Aman)**
- Local tetap pakai data testing saja
- Production tetap pakai data real users
- Lebih aman dari kecelakaan data corruption

---

## 💾 Backup Strategy yang Anda Gunakan

### Saat Ini (Manual via PHPMyAdmin):
- ❌ Berisiko terlupakan
- ❌ Tidak trackable
- ❌ Susah di-restore

### Recommended (Auto Backup):
```
Auto-backup harian jam 2 pagi via cron job
├── Database: db_backup_YYYYMMDD_HHMMSS.sql.gz
├── Storage: storage_backup_YYYYMMDD_HHMMSS.tar.gz
└── Retained: 30 hari (auto-delete old)
```

### Advantages:
- ✅ Automatic, tidak perlu diinget
- ✅ Trackable history
- ✅ Easy to restore
- ✅ Compressed (hemat space)

---

## 🔄 Weekly Deployment Workflow

### Hari Kerja (Developer):
```
Senin-Jumat
  ↓
Develop fitur baru di local
  ↓
Test di local
  ↓
git commit + git push GitHub
  ↓
Ready untuk deploy
```

### Hari Deployment (Admin/Anda):
```
Jum'at Sore / Sabtu Pagi
  ↓
ssh ke server
  ↓
git pull origin main
  ↓
./deploy.sh
  ↓
Test di production
  ↓
Monitor logs
  ↓
Done!
```

---

## 🎓 Konsep Penting

### Git Workflow:
```
Work → Commit → Push → Pull → Deploy
```

### Backup Strategy:
```
Auto Daily (2 AM) → Compressed → 30-day retention → Cloud (opsional)
```

### Disaster Recovery Plan:
```
Error Terjadi → Check Logs → Rollback Commit → Restore Database → Test
```

---

## 📱 Useful Commands Cheatsheet

### Local Development:
```bash
git status              # Check perubahan
git add .              # Stage semua
git commit -m "msg"    # Commit dengan message
git push origin main   # Push ke GitHub
git log --oneline      # Lihat history
```

### Production Server:
```bash
git pull origin main                    # Pull update
./deploy.sh                            # Run deployment
php artisan logs                       # View logs
tail -f storage/logs/laravel.log      # Monitor logs realtime
mysql -u root -p igrasumut_rapor      # Connect database
mysqldump -u root -p db > backup.sql  # Backup database
```

---

## ⚠️ Safety First

### Sebelum Setiap Deployment:
- [ ] Backup database
- [ ] Backup folder aplikasi
- [ ] Test di local terlebih dahulu
- [ ] Read deployment guide
- [ ] Monitor logs setelah deploy

### Jangan:
- ❌ Deploy tanpa backup
- ❌ Delete file tanpa backup
- ❌ Deploy ke production tanpa test di local
- ❌ Use same password untuk semua
- ❌ Push sensitive info (API keys, passwords)

---

## 🆘 Support & Troubleshooting

### Jika Ada Error:

1. **Check Logs First**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Rollback (Revert last commit)**
   ```bash
   git revert HEAD
   git push origin main
   ```

3. **Restore Database**
   ```bash
   mysql -u root -p db_name < backup_file.sql
   ```

4. **Clear Everything**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   php artisan migrate:refresh  # ⚠️ DANGER - delete data!
   ```

---

## ✅ Success Indicators

Setelah deployment sukses:

- ✅ Website accessible di igrasumut.com
- ✅ Logo & Favicon muncul di header
- ✅ Admin dapat edit branding
- ✅ Changes saved ke database
- ✅ Welcome page update reflect
- ✅ No error di logs
- ✅ User data intact

---

## 📞 Quick Reference

**Hosting**: JagoanHosting
**Domain**: igrasumut.com
**Repository**: github.com/YOUR_USERNAME/rapor-igra-sumut
**Database**: igrasumut_rapor
**Framework**: Laravel 11
**Deployment**: Git-based dengan script automation

---

**Created**: Nov 22, 2025
**Status**: Ready for Implementation

