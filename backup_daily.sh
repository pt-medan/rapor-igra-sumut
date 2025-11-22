#!/bin/bash

###########################################################################
# AUTO BACKUP SCRIPT FOR E-RAPOR IGRA SUMUT
# Setup dengan cron: 0 2 * * * /home/igrasumut/backup_daily.sh
# This runs every day at 2 AM
###########################################################################

# Configuration - SESUAIKAN DENGAN SETTING HOSTING ANDA
DB_USER="root"
DB_PASS=""
DB_NAME="igrasumut_rapor"
BACKUP_DIR="/home/igrasumut/backups"
DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/home/igrasumut/backup.log"
RETENTION_DAYS=30

# Create backup directory if not exists
mkdir -p $BACKUP_DIR

# Log function
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> $LOG_FILE
}

log "================================"
log "Starting backup process..."

# Backup database
DB_BACKUP_FILE="$BACKUP_DIR/db_backup_$DATE.sql"

if [ -z "$DB_PASS" ]; then
    mysqldump -u $DB_USER $DB_NAME > $DB_BACKUP_FILE 2>> $LOG_FILE
else
    mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $DB_BACKUP_FILE 2>> $LOG_FILE
fi

if [ $? -eq 0 ]; then
    # Compress backup
    gzip $DB_BACKUP_FILE
    DB_BACKUP_FILE="$DB_BACKUP_FILE.gz"
    SIZE=$(du -h $DB_BACKUP_FILE | cut -f1)
    log "✓ Database backup created: $DB_BACKUP_FILE ($SIZE)"
else
    log "✗ Database backup FAILED"
    exit 1
fi

# Backup storage/website uploads
STORAGE_BACKUP_FILE="$BACKUP_DIR/storage_backup_$DATE.tar.gz"
tar -czf $STORAGE_BACKUP_FILE /var/www/igrasumut.com/storage/app/public/ 2>> $LOG_FILE

if [ $? -eq 0 ]; then
    SIZE=$(du -h $STORAGE_BACKUP_FILE | cut -f1)
    log "✓ Storage backup created: $STORAGE_BACKUP_FILE ($SIZE)"
else
    log "✗ Storage backup FAILED"
fi

# Delete old backups (older than 30 days)
DELETED=$(find $BACKUP_DIR -type f -mtime +$RETENTION_DAYS -delete -print | wc -l)
log "✓ Deleted $DELETED old backup files"

# Summary
TOTAL_SIZE=$(du -sh $BACKUP_DIR | cut -f1)
log "Total backup size: $TOTAL_SIZE"
log "Backup process completed!"
log ""

# Optional: Upload to cloud (Google Drive, Dropbox, etc)
# Uncomment if you want to backup ke cloud storage

# Upload to Dropbox example:
# /usr/local/bin/dropbox_uploader upload $DB_BACKUP_FILE /Backups/
# log "✓ Backup uploaded to Dropbox"

