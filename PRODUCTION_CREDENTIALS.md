# 📋 CREDENTIALS STORAGE - KEEP THIS SAFE!

⚠️ **WARNING**: This file contains sensitive credentials. Never commit to Git!

---

## 🔐 PRODUCTION SERVER INFO

### SSH Access
```
Host: dream.jagoanhosting.id
Username: igrasumu
Password: S3fr1f@dhl@n
Port: ?? (Need to confirm with hosting)
Status: ❌ Connection timeout - troubleshooting
```

### Database Access
```
Database Name: igrasumu_rapor
DB Username: igrasumu_sefri
DB Password: S3frifadhlan
DB Host: localhost (usually)
DB Port: 3306 (default)
```

### Application
```
Location: /public_html
Domain: igrasumut.com
```

### cPanel Access
```
URL: https://dream.jagoanhosting.id:2083/
Username: igrasumu
Password: S3fr1f@dhl@n
```

---

## 🛠️ USEFUL COMMANDS (Once SSH Works)

```bash
# Connect via SSH
ssh igrasumu@dream.jagoanhosting.id

# Navigate to app
cd /public_html

# Clone repository
git clone https://github.com/pt-medan/rapor-igra-sumut.git

# Deploy
./deploy.sh

# View logs
tail -f storage/logs/laravel.log

# Backup database
mysqldump -u igrasumu_sefri -p igrasumu_rapor > backup.sql
# Password: S3frifadhlan
```

---

## 📌 IMPORTANT NOTES

1. **Don't commit this file to Git** - It's sensitive!
2. **Keep credentials safe** - Don't share
3. **Use for reference only** - Copy-paste carefully
4. **Change passwords after successful deployment**
5. **Enable 2FA on cPanel** - For security

---

## ✅ NEXT STEPS

1. Wait for JagoanHosting response on SSH
2. Once SSH works, test connection
3. Run deployment script
4. Setup auto-backups
5. Monitor production

---

**Created**: November 22, 2025
**Status**: Awaiting SSH confirmation

