# 🚀 QUICK START - DEPLOYMENT CHECKLIST

## Untuk Admin Lokal (Developer)

### Setiap Kali Ingin Deploy Fitur Baru:

```bash
# 1. Pastikan sudah test di local dan tidak ada error
# 2. Commit perubahan
cd /Users/macbook/Downloads/prod_rapor_igra
git add .
git commit -m "Add/Fix: Deskripsi fitur atau bug fix"

# 3. Push ke GitHub
git push origin main

# 4. Verifikasi di GitHub.com bahwa commit muncul
# 5. Beri tau hosting admin/Anda bahwa ada update siap di-deploy
```

---

## Untuk Admin Server (Hosting)

### Setup Awal (One-time only):

```bash
# 1. SSH ke server
ssh username@igrasumut.com

# 2. Navigate ke folder aplikasi
cd /var/www/igrasumut.com
# atau sesuai struktur hosting Anda

# 3. Setup git
git config --global user.name "Deployment"
git config --global user.email "deploy@igrasumut.com"

# 4. Clone repository (gunakan HTTPS jika SSH error)
git clone https://github.com/YOUR_USERNAME/rapor-igra-sumut.git temp-app
cp -r temp-app/* ./
rm -rf temp-app

# 5. Setup .env dengan production settings
cp /path/to/old/.env .env
# Edit .env untuk production database credentials

# 6. First time setup
chmod +x deploy.sh backup_daily.sh
./deploy.sh

# 7. Setup backup otomatis
crontab -e
# Add line: 0 2 * * * /var/www/igrasumut.com/backup_daily.sh
# Save and exit (Ctrl+O, Ctrl+X for nano)

# 8. Test website di browser
exit
```

### Setiap Kali Ada Update (Regular Deployment):

```bash
# 1. SSH ke server
ssh username@igrasumut.com

# 2. Navigate ke folder
cd /var/www/igrasumut.com

# 3. Pull kode terbaru
git pull origin main

# 4. Run deployment script
./deploy.sh

# 5. Test website
# 6. Done!

exit
```

---

## 📝 Git Commands untuk Pemula

### Untuk Local Development:

```bash
# Check status
git status

# Add perubahan
git add .              # semua file
git add filename.php   # file spesifik

# Commit perubahan
git commit -m "Deskripsi perubahan"

# Push ke GitHub
git push origin main

# Lihat history commit
git log --oneline

# Undo perubahan belum di-commit
git checkout -- filename.php

# Undo last commit (tapi keep file)
git reset --soft HEAD~1

# Undo last commit (hapus changes)
git reset --hard HEAD~1
```

### Untuk Production Server:

```bash
# Pull update terbaru
git pull origin main

# Check last commit
git log -1

# Check status
git status

# Rollback ke commit sebelumnya (jika ada error)
git revert HEAD
git push origin main
```

---

## 🐛 Debugging Tips

### Jika ada error saat deploy:

```bash
# 1. Check Laravel logs
tail -f storage/logs/laravel.log

# 2. Check server error logs
tail -f /var/log/apache2/error.log
tail -f /var/log/php-fpm.log

# 3. Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 4. Check database connection
php artisan tinker
DB::connection()->getPDO();
exit

# 5. Check storage symlink
ls -la public/storage

# 6. Check file permissions
ls -la storage/
ls -la bootstrap/cache/
```

---

## 💡 Best Practices

1. **Always Backup Before Deploy**
   ```bash
   mysqldump -u root -p igrasumut_rapor > backup_before_deploy.sql
   ```

2. **Test di Local Terlebih Dahulu**
   - Jangan langsung push tanpa test

3. **Write Good Commit Messages**
   - ✅ `git commit -m "Add: Admin dashboard for statistics"`
   - ❌ `git commit -m "update"`

4. **Pull dari GitHub Dulu Sebelum Kerja**
   ```bash
   git pull origin main
   ```

5. **Resolve Conflicts Sebelum Push**
   ```bash
   git status  # lihat conflict
   # Fix manually
   git add .
   git commit -m "Resolve conflicts"
   git push origin main
   ```

6. **Monitor Production After Deploy**
   - Check logs: `tail -f storage/logs/laravel.log`
   - Check website functionality
   - Monitor database size

---

## 📋 Weekly Maintenance

- [ ] Check backup folder size
- [ ] Review server error logs
- [ ] Test user login & basic features
- [ ] Check storage disk space
- [ ] Verify database backups exist

---

## 🆘 Emergency Contacts

Jika ada masalah urgent:

1. **Cek Logs Dulu** - banyak masalah bisa dilihat di logs
2. **Rollback ke Commit Sebelumnya** - jika error serius
3. **Restore dari Backup** - jika database corrupt
4. **Contact Hosting Support** - jika server issue

---

**Version:** 1.0 | **Last Updated:** Nov 22, 2025

