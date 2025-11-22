# 🚀 BACKUP SETUP - QUICK EXECUTION GUIDE

**Time to Complete**: ~5 minutes  
**Difficulty**: Easy  
**Prerequisites**: cPanel Terminal access  

---

## ⚡ QUICK SETUP (Copy-Paste All Commands Below)

### **Execute in cPanel Terminal:**

```bash
# ============================================================================
# STEP 1: Create Backup Directory
# ============================================================================
mkdir -p /home/igrasumu/backups
chmod 700 /home/igrasumu/backups
ls -la /home/igrasumu/ | grep backups

# ============================================================================
# STEP 2: Create Backup Script
# ============================================================================
cd /home/igrasumu/public_html

cat > backup_daily.sh << 'BACKUP_SCRIPT_EOF'
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

# Backup Database
echo "[INFO] Backing up database..."
BACKUP_FILE="$BACKUP_DIR/db_${DATE}.sql"
mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_FILE"
DB_SIZE=$(du -h "$BACKUP_FILE" | cut -f1)
echo "[OK] Database backup: $DB_SIZE"

# Backup Storage
echo "[INFO] Backing up storage files..."
STORAGE_BACKUP="$BACKUP_DIR/storage_${DATE}.tar.gz"
tar -czf "$STORAGE_BACKUP" -C "$APP_PATH" storage/app/public 2>/dev/null
STORAGE_SIZE=$(du -h "$STORAGE_BACKUP" | cut -f1)
echo "[OK] Storage backup: $STORAGE_SIZE"

# Cleanup old backups (keep 7 days)
echo "[INFO] Cleaning up old backups..."
find "$BACKUP_DIR" -name "db_*.sql" -type f -mtime +7 -delete
find "$BACKUP_DIR" -name "storage_*.tar.gz" -type f -mtime +7 -delete

echo "=========================================="
echo "$(date '+%Y-%m-%d %H:%M:%S') - BACKUP COMPLETED"
echo "=========================================="
echo ""
echo "[SUMMARY]"
echo "  Total Backups (db):      $(ls -1 $BACKUP_DIR/db_*.sql 2>/dev/null | wc -l)"
echo "  Total Backups (storage): $(ls -1 $BACKUP_DIR/storage_*.tar.gz 2>/dev/null | wc -l)"
echo "  Disk Usage:              $(du -sh $BACKUP_DIR | cut -f1)"

BACKUP_SCRIPT_EOF

chmod +x backup_daily.sh
echo "✅ Backup script created!"

# ============================================================================
# STEP 3: Test Backup Script
# ============================================================================
echo ""
echo "Running backup test..."
bash backup_daily.sh
echo ""

# ============================================================================
# STEP 4: Verify Backups Created
# ============================================================================
echo "Checking backups..."
ls -lah /home/igrasumu/backups/
echo ""

# ============================================================================
# STEP 5: Setup Cron Job (Auto Run Daily at 2 AM)
# ============================================================================
echo "Setting up cron job..."

# Add cron job
(crontab -l 2>/dev/null; echo "0 2 * * * /home/igrasumu/public_html/backup_daily.sh >> /home/igrasumu/backups/cron.log 2>&1") | crontab -

# Verify cron job
echo ""
echo "Cron job status:"
crontab -l | grep backup_daily.sh
echo ""

echo "=========================================="
echo "✅ BACKUP SETUP COMPLETED!"
echo "=========================================="
echo ""
echo "Summary:"
echo "  ✅ Backup directory created"
echo "  ✅ Backup script installed"
echo "  ✅ First backup tested"
echo "  ✅ Cron job scheduled (daily at 2 AM)"
echo ""
echo "Monitor backups with:"
echo "  tail -f /home/igrasumu/backups/cron.log"
echo ""
echo "List backups with:"
echo "  ls -lh /home/igrasumu/backups/"
echo ""
```

---

## ✅ VERIFICATION COMMANDS

After setup, run these to verify everything is working:

```bash
# 1. Check backup files created
ls -lh /home/igrasumu/backups/

# 2. Verify cron job
crontab -l | grep backup

# 3. Check cron logs (after first scheduled run)
tail -20 /home/igrasumu/backups/cron.log

# 4. Manual test of backup script
bash /home/igrasumu/public_html/backup_daily.sh

# 5. Check disk usage of backups
du -sh /home/igrasumu/backups

# 6. Verify database backup file
file /home/igrasumu/backups/db_*.sql | head -1
```

---

## 📊 WHAT TO EXPECT

### **After First Run:**
```
✅ Database backup created (typically 1-5 MB)
✅ Storage backup created (typically 0.5-2 MB)
✅ Backup log file created at /home/igrasumu/backups/cron.log
```

### **Daily Backups (Automatic at 2 AM):**
```
Day 1: 2 files (db + storage)
Day 2: 4 files (2 daily sets)
Day 3: 6 files (3 daily sets)
...
Day 7: 14 files (7 daily sets)
Day 8: 14 files (oldest set auto-deleted, new set added)
```

---

## 🔍 MONITORING

### **Check Latest Backup:**
```bash
ls -lht /home/igrasumu/backups/ | head -5
```

### **Check Backup Disk Usage:**
```bash
du -sh /home/igrasumu/backups/
```

### **View Cron Log:**
```bash
tail -50 /home/igrasumu/backups/cron.log
```

---

## ⚠️ IF SOMETHING GOES WRONG

### **Backup Script Failed:**
```bash
# Run manually to see error
bash /home/igrasumu/public_html/backup_daily.sh

# Check if MySQL credentials are correct
mysql -u igrasumu_sefri -pS3frifadhlan -e "SELECT VERSION();"
```

### **Cron Job Not Running:**
```bash
# Check if cron is installed
crontab -l

# Check system cron logs
grep CRON /var/log/syslog | tail -10

# Re-add cron job
(crontab -l 2>/dev/null; echo "0 2 * * * /home/igrasumu/public_html/backup_daily.sh >> /home/igrasumu/backups/cron.log 2>&1") | crontab -
```

---

## 📝 ADDITIONAL NOTES

- **Backup Time**: ~30 seconds to 2 minutes per backup
- **Retention**: Automatically keeps last 7 days
- **Best Time**: 2 AM (automatic cron job)
- **Manual Backup**: Run `bash /home/igrasumu/public_html/backup_daily.sh` anytime
- **Restore**: See BACKUP_SETUP_GUIDE.md for restore instructions

---

**Status**: ✅ Ready to Execute  
**Last Updated**: November 22, 2025
