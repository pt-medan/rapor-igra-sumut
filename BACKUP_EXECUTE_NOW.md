# 🎯 BACKUP SETUP - COPY-PASTE FOR CPANEL TERMINAL

**Copy-paste semua command di bawah ini satu per satu di cPanel Terminal**

---

## ✅ EXECUTION (Jalankan di cPanel Terminal)

### **Command 1: Create Backup Directory**

Copy & Paste:
```bash
mkdir -p /home/igrasumu/backups && chmod 700 /home/igrasumu/backups && ls -la /home/igrasumu/ | grep backups
```

Expected output:
```
drwx------  2 igrasumu igrasumu 4096 Nov 22 14:30 backups
```

---

### **Command 2: Create Backup Script**

Copy & Paste:
```bash
cd /home/igrasumu/public_html && cat > backup_daily.sh << 'BACKUP_SCRIPT_EOF'
#!/bin/bash
BACKUP_DIR="/home/igrasumu/backups"
APP_PATH="/home/igrasumu/public_html"
DATE=$(date +"%Y%m%d_%H%M%S")
DB_HOST="localhost"
DB_PORT="3306"
DB_NAME="igrasumu_rapor"
DB_USER="igrasumu_sefri"
DB_PASS="S3frifadhlan"
mkdir -p "$BACKUP_DIR"
echo "=========================================="
echo "$(date '+%Y-%m-%d %H:%M:%S') - BACKUP START"
echo "=========================================="
echo "[INFO] Backing up database..."
BACKUP_FILE="$BACKUP_DIR/db_${DATE}.sql"
mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_FILE" 2>/dev/null
if [ -s "$BACKUP_FILE" ]; then
    DB_SIZE=$(du -h "$BACKUP_FILE" | cut -f1)
    echo "[OK] Database backup: $DB_SIZE"
else
    echo "[ERROR] Database backup failed!"
fi
echo "[INFO] Backing up storage files..."
STORAGE_BACKUP="$BACKUP_DIR/storage_${DATE}.tar.gz"
tar -czf "$STORAGE_BACKUP" -C "$APP_PATH" storage/app/public 2>/dev/null
if [ -s "$STORAGE_BACKUP" ]; then
    STORAGE_SIZE=$(du -h "$STORAGE_BACKUP" | cut -f1)
    echo "[OK] Storage backup: $STORAGE_SIZE"
else
    echo "[WARNING] Storage backup is empty or failed"
fi
echo "[INFO] Cleaning up old backups (7 days+)..."
find "$BACKUP_DIR" -name "db_*.sql" -type f -mtime +7 -delete 2>/dev/null
find "$BACKUP_DIR" -name "storage_*.tar.gz" -type f -mtime +7 -delete 2>/dev/null
echo "=========================================="
echo "$(date '+%Y-%m-%d %H:%M:%S') - BACKUP COMPLETED"
echo "=========================================="
echo "[SUMMARY]"
echo "  DB Backups:      $(ls -1 $BACKUP_DIR/db_*.sql 2>/dev/null | wc -l)"
echo "  Storage Backups: $(ls -1 $BACKUP_DIR/storage_*.tar.gz 2>/dev/null | wc -l)"
echo "  Disk Usage:      $(du -sh $BACKUP_DIR 2>/dev/null | cut -f1)"
BACKUP_SCRIPT_EOF
chmod +x backup_daily.sh && echo "✅ Script created!"
```

Expected output:
```
✅ Script created!
```

---

### **Command 3: Test Backup Script**

Copy & Paste:
```bash
cd /home/igrasumu/public_html && bash backup_daily.sh
```

Expected output:
```
==========================================
YYYY-MM-DD HH:MM:SS - BACKUP START
==========================================
[INFO] Backing up database...
[OK] Database backup: X.XM
[INFO] Backing up storage files...
[OK] Storage backup: XXXK
[INFO] Cleaning up old backups (7 days+)...
==========================================
YYYY-MM-DD HH:MM:SS - BACKUP COMPLETED
==========================================
[SUMMARY]
  DB Backups:      1
  Storage Backups: 1
  Disk Usage:      X.XM
```

---

### **Command 4: Verify Backups**

Copy & Paste:
```bash
ls -lh /home/igrasumu/backups/
```

Expected output:
```
-rw-r--r-- 1 igrasumu igrasumu 1.5M Nov 22 14:30 db_20251122_143000.sql
-rw-r--r-- 1 igrasumu igrasumu 256K Nov 22 14:30 storage_20251122_143000.tar.gz
```

---

### **Command 5: Setup Cron Job**

Copy & Paste (one line):
```bash
(crontab -l 2>/dev/null; echo "0 2 * * * /home/igrasumu/public_html/backup_daily.sh >> /home/igrasumu/backups/cron.log 2>&1") | crontab - && echo "✅ Cron job added!" && crontab -l
```

Expected output:
```
✅ Cron job added!
0 2 * * * /home/igrasumu/public_html/backup_daily.sh >> /home/igrasumu/backups/cron.log 2>&1
```

---

## 🎉 SETUP COMPLETE!

### **Next Steps:**

1. ✅ Backup directory created at `/home/igrasumu/backups`
2. ✅ Backup script installed at `/home/igrasumu/public_html/backup_daily.sh`
3. ✅ First backup tested successfully
4. ✅ Cron job scheduled for daily execution at **2:00 AM**

### **Monitor Your Backups:**

```bash
# View latest backups
ls -lht /home/igrasumu/backups/ | head -10

# Check backup schedule (runs automatically daily at 2 AM)
crontab -l | grep backup

# After first scheduled run, check logs
tail -20 /home/igrasumu/backups/cron.log
```

---

## 📋 WHAT HAPPENS AUTOMATICALLY

**Every day at 2:00 AM:**
- ✅ Database backup created (`db_YYYYMMDD_HHMMSS.sql`)
- ✅ Storage files backup created (`storage_YYYYMMDD_HHMMSS.tar.gz`)
- ✅ Old backups (7+ days) automatically deleted
- ✅ Log file updated at `/home/igrasumu/backups/cron.log`

**Backup Retention:**
- Keep last 7 days of backups automatically
- Each backup set = 1-2 MB total
- 7-day retention = ~10-14 MB disk usage (very manageable)

---

## 🔧 MANUAL BACKUP ANYTIME

If you want to backup manually:
```bash
cd /home/igrasumu/public_html && bash backup_daily.sh
```

---

## 🚀 WHAT'S NEXT?

All setup complete! Your application now has:

✅ **Live Website**: https://igrasumut.com  
✅ **Database**: Fully configured (MySQL)  
✅ **Storage**: Configured with symlink  
✅ **Auto-Backups**: Running daily at 2 AM  
✅ **GitHub Repository**: All code backed up  

### **Future Enhancements** (Optional):
- [ ] Setup SSH access for easier deployments
- [ ] Setup email notifications on backup failure
- [ ] Upload backups to cloud storage (S3, Google Drive, etc.)
- [ ] Setup staging environment for testing
- [ ] Setup monitoring/alerting system

---

**Status**: ✅ Production Deployment Complete!  
**Last Updated**: November 22, 2025
