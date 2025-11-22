# 🛡️ AUTO-BACKUP SETUP GUIDE

**Production Application**: igrasumut.com  
**Setup Date**: November 22, 2025  
**Backup Type**: Daily automated backups (Database + Storage)  
**Retention**: Keep last 7 days

---

## 📋 BACKUP STRATEGY OVERVIEW

| Component | Backup Type | Frequency | Location | Retention |
|-----------|------------|-----------|----------|-----------|
| **Database** | MySQL Dump (.sql) | Daily @ 2 AM | `/home/igrasumu/backups/` | 7 days |
| **Upload Files** | TAR.GZ Archive | Daily @ 2 AM | `/home/igrasumu/backups/` | 7 days |
| **Logs** | Cron job logs | Daily | `/home/igrasumu/backups/cron.log` | Auto-rotate |

---

## 🚀 SETUP STEPS (COPY-PASTE READY)

### **STEP 1: Create Backup Directory**

```bash
cd /home/igrasumu/public_html

# Create backups folder
mkdir -p /home/igrasumu/backups

# Set proper permissions
chmod 700 /home/igrasumu/backups

# Verify
ls -la /home/igrasumu/ | grep backups
```

**Expected Output:**
```
drwx------  2 igrasumu igrasumu 4096 Nov 22 14:30 backups
```

---

### **STEP 2: Create Backup Script**

```bash
cd /home/igrasumu/public_html

# Create the backup script
cat > backup_daily.sh << 'BACKUP_SCRIPT_EOF'
#!/bin/bash

# ==============================================================================
# AUTO-BACKUP SCRIPT FOR IGRASUMUT.COM
# ==============================================================================
# Purpose: Daily backup of database and uploaded files
# Schedule: Cron job at 2 AM every day
# Author: Deployment Team
# ==============================================================================

# Configuration
BACKUP_DIR="/home/igrasumu/backups"
APP_PATH="/home/igrasumu/public_html"
DATE=$(date +"%Y%m%d_%H%M%S")
WEEK_AGO=$(date -d "7 days ago" +"%Y%m%d")

# Database credentials (from .env)
DB_HOST="localhost"
DB_PORT="3306"
DB_NAME="igrasumu_rapor"
DB_USER="igrasumu_sefri"
DB_PASS="S3frifadhlan"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Create backup directory if not exists
mkdir -p "$BACKUP_DIR"

echo "=========================================="
echo "$(date '+%Y-%m-%d %H:%M:%S') - BACKUP START"
echo "=========================================="

# ==============================================================================
# 1. BACKUP DATABASE
# ==============================================================================
echo ""
echo "[INFO] Backing up database: $DB_NAME"

BACKUP_FILE="$BACKUP_DIR/db_${DATE}.sql"

mysqldump \
  --single-transaction \
  --lock-tables=false \
  --quick \
  -h "$DB_HOST" \
  -P "$DB_PORT" \
  -u "$DB_USER" \
  -p"$DB_PASS" \
  "$DB_NAME" > "$BACKUP_FILE"

if [ $? -eq 0 ]; then
    DB_SIZE=$(du -h "$BACKUP_FILE" | cut -f1)
    echo -e "${GREEN}[OK]${NC} Database backup created: $DB_SIZE"
else
    echo -e "${RED}[ERROR]${NC} Database backup FAILED!"
    exit 1
fi

# ==============================================================================
# 2. BACKUP STORAGE FILES
# ==============================================================================
echo ""
echo "[INFO] Backing up storage files..."

STORAGE_BACKUP="$BACKUP_DIR/storage_${DATE}.tar.gz"

tar -czf "$STORAGE_BACKUP" \
    -C "$APP_PATH" \
    storage/app/public \
    2>/dev/null

if [ $? -eq 0 ]; then
    STORAGE_SIZE=$(du -h "$STORAGE_BACKUP" | cut -f1)
    echo -e "${GREEN}[OK]${NC} Storage backup created: $STORAGE_SIZE"
else
    echo -e "${RED}[ERROR]${NC} Storage backup FAILED!"
    exit 1
fi

# ==============================================================================
# 3. CLEANUP OLD BACKUPS (Keep last 7 days)
# ==============================================================================
echo ""
echo "[INFO] Cleaning up old backups (keeping last 7 days)..."

OLD_DB_BACKUPS=$(find "$BACKUP_DIR" -name "db_*.sql" -type f -mtime +7)
OLD_STORAGE_BACKUPS=$(find "$BACKUP_DIR" -name "storage_*.tar.gz" -type f -mtime +7)

if [ -n "$OLD_DB_BACKUPS" ]; then
    echo "$OLD_DB_BACKUPS" | while read file; do
        rm -f "$file"
        echo -e "${YELLOW}[DELETED]${NC} $(basename $file)"
    done
fi

if [ -n "$OLD_STORAGE_BACKUPS" ]; then
    echo "$OLD_STORAGE_BACKUPS" | while read file; do
        rm -f "$file"
        echo -e "${YELLOW}[DELETED]${NC} $(basename $file)"
    done
fi

# ==============================================================================
# 4. GENERATE SUMMARY REPORT
# ==============================================================================
echo ""
echo "=========================================="
echo "$(date '+%Y-%m-%d %H:%M:%S') - BACKUP COMPLETED"
echo "=========================================="
echo ""
echo "[SUMMARY]"
echo "  Database Backup: $(basename $BACKUP_FILE)"
echo "  Storage Backup:  $(basename $STORAGE_BACKUP)"
echo "  Total Backups:   $(ls -1 $BACKUP_DIR/db_*.sql 2>/dev/null | wc -l) db files"
echo "  Total Backups:   $(ls -1 $BACKUP_DIR/storage_*.tar.gz 2>/dev/null | wc -l) storage files"
echo "  Disk Usage:      $(du -sh $BACKUP_DIR | cut -f1)"
echo "=========================================="

BACKUP_SCRIPT_EOF

# Make script executable
chmod +x backup_daily.sh

# Verify script created
if [ -f "backup_daily.sh" ]; then
    echo "✅ Backup script created successfully!"
    wc -l backup_daily.sh
else
    echo "❌ Failed to create backup script!"
    exit 1
fi
```

**Expected Output:**
```
✅ Backup script created successfully!
     125 backup_daily.sh
```

---

### **STEP 3: Test Backup Script**

```bash
cd /home/igrasumu/public_html

# Run backup script manually to test
bash backup_daily.sh

# Check the output
ls -lah /home/igrasumu/backups/
```

**Expected Output:**
```
==========================================
YYYY-MM-DD HH:MM:SS - BACKUP START
==========================================

[INFO] Backing up database: igrasumu_rapor
[OK] Database backup created: 1.5M
[INFO] Backing up storage files...
[OK] Storage backup created: 256K

[SUMMARY]
  Database Backup: db_20251122_143000.sql
  Storage Backup:  storage_20251122_143000.tar.gz
  Total Backups:   1 db files
  Total Backups:   1 storage files
  Disk Usage:      1.8M
==========================================
```

---

### **STEP 4: Setup Cron Job for Automatic Backup**

```bash
# Open crontab editor
crontab -e

# Add this line at the end (run backup every day at 2 AM):
0 2 * * * /home/igrasumu/public_html/backup_daily.sh >> /home/igrasumu/backups/cron.log 2>&1

# Save and exit (Press ESC, then type :wq and press Enter)
```

**Verify Cron Job:**
```bash
# List your cron jobs
crontab -l

# Expected Output:
# 0 2 * * * /home/igrasumu/public_html/backup_daily.sh >> /home/igrasumu/backups/cron.log 2>&1
```

---

## 🔍 MONITORING & MAINTENANCE

### **Check Last Backup**
```bash
cd /home/igrasumu/backups

# List all backups
ls -lh

# Check most recent backups
ls -lht | head -10

# Check backup sizes
du -sh *
```

### **Monitor Cron Execution**
```bash
# View cron log
tail -20 /home/igrasumu/backups/cron.log

# Real-time monitoring (if available)
tail -f /home/igrasumu/backups/cron.log
```

### **Verify Database Backup Integrity**
```bash
# Check if backup can be restored (TEST ONLY - don't run on production)
# This is just for verification, don't actually restore!
mysql -u igrasumu_sefri -pS3frifadhlan -e "SOURCE /home/igrasumu/backups/db_LATEST.sql" 2>&1 | head -20

# Or check backup file size (should not be 0 or very small)
ls -lh /home/igrasumu/backups/db_*.sql | tail -5
```

---

## 📊 BACKUP STATISTICS

```bash
# Get disk usage by backups
du -sh /home/igrasumu/backups

# Count total backups
echo "Database backups: $(ls -1 /home/igrasumu/backups/db_*.sql 2>/dev/null | wc -l)"
echo "Storage backups: $(ls -1 /home/igrasumu/backups/storage_*.tar.gz 2>/dev/null | wc -l)"

# List all backups with timestamps
find /home/igrasumu/backups -type f -printf '%TY-%Tm-%Td %TH:%TM %s %p\n' | sort -r
```

---

## 🔐 RESTORE FROM BACKUP (IF NEEDED)

### **Restore Database**
```bash
# List available backups
ls -1 /home/igrasumu/backups/db_*.sql

# Choose a backup and restore (example)
BACKUP_FILE="/home/igrasumu/backups/db_20251122_143000.sql"

# Before restoring, create a backup of current database
mysqldump -u igrasumu_sefri -pS3frifadhlan igrasumu_rapor > /tmp/current_backup.sql

# Restore from backup
mysql -u igrasumu_sefri -pS3frifadhlan igrasumu_rapor < "$BACKUP_FILE"

# Verify restore
mysql -u igrasumu_sefri -pS3frifadhlan -e "USE igrasumu_rapor; SELECT COUNT(*) as total_rows FROM siswa;"
```

### **Restore Storage Files**
```bash
# List available backups
ls -1 /home/igrasumu/backups/storage_*.tar.gz

# Choose a backup and restore (example)
BACKUP_FILE="/home/igrasumu/backups/storage_20251122_143000.tar.gz"

# Create backup of current storage (if needed)
tar -czf /tmp/storage_current.tar.gz /home/igrasumu/public_html/storage/app/public

# Restore from backup
cd /home/igrasumu/public_html
tar -xzf "$BACKUP_FILE"

# Verify
ls -la storage/app/public/
```

---

## ⚠️ TROUBLESHOOTING

### **Backup Script Not Running**

```bash
# 1. Verify cron is running
systemctl status cron
# or
ps aux | grep cron

# 2. Check cron logs
grep CRON /var/log/syslog | tail -20

# 3. Test script manually
bash /home/igrasumu/public_html/backup_daily.sh

# 4. Check script permissions
ls -la /home/igrasumu/public_html/backup_daily.sh
# Should show: -rwxr-xr-x (755 or similar)

# 5. Check backup directory permissions
ls -la /home/igrasumu/backups
# Should show: drwx------ (700)
```

### **Backup Size Too Large**

```bash
# Check what's taking space
du -sh /home/igrasumu/backups/*

# If storage_*.tar.gz is too large, check storage folder size
du -sh /home/igrasumu/public_html/storage/app/public/

# Clean up old uploads if needed
find /home/igrasumu/public_html/storage/app/public -type f -mtime +30 -delete
```

### **Database Backup Fails**

```bash
# Test MySQL connection
mysql -u igrasumu_sefri -pS3frifadhlan -e "SELECT VERSION();"

# Check if credentials are correct
mysql -u igrasumu_sefri -pS3frifadhlan -e "SHOW DATABASES;"

# Test backup manually
mysqldump -u igrasumu_sefri -pS3frifadhlan igrasumu_rapor > /tmp/test_backup.sql

# Check error log
tail -50 /home/igrasumu/public_html/storage/logs/laravel.log
```

---

## 📅 BACKUP RETENTION POLICY

| Age | Action |
|-----|--------|
| **0-7 days** | Keep all backups |
| **7+ days** | Automatically deleted |
| **Manual backups** | Keep indefinitely |

To keep longer backups, upload them to cloud storage:
- AWS S3
- Google Drive
- Dropbox
- FTP server

---

## 🎯 NEXT STEPS

1. ✅ Test backup script: `bash backup_daily.sh`
2. ✅ Verify cron job: `crontab -l`
3. ✅ Monitor logs: `tail -f /home/igrasumu/backups/cron.log`
4. ⏳ [Optional] Setup cloud backup sync
5. ⏳ [Optional] Setup email notifications on backup failure

---

## 📞 SUPPORT

If you encounter issues:
1. Check cron logs: `/home/igrasumu/backups/cron.log`
2. Run script manually: `bash /home/igrasumu/public_html/backup_daily.sh`
3. Verify MySQL credentials in script
4. Check disk space: `df -h /home/igrasumu`

---

**Last Updated**: November 22, 2025  
**Status**: ✅ Ready for Production
