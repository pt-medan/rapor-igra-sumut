#!/bin/bash

###########################################################################
# DEPLOYMENT SCRIPT FOR E-RAPOR IGRA SUMUT
# Run this script on production server after git pull
# Usage: ./deploy.sh
###########################################################################

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}========================================${NC}"
echo -e "${YELLOW}  E-RAPOR IGRA SUMUT - DEPLOYMENT${NC}"
echo -e "${YELLOW}========================================${NC}"
echo ""

# Step 1: Backup current database
echo -e "${YELLOW}[1/8] Creating database backup...${NC}"
DB_USER=${DB_USER:-"root"}
DB_PASS=${DB_PASS:-""}
DB_NAME=${DB_NAME:-"igrasumut_rapor"}
BACKUP_DIR="./backups"

mkdir -p $BACKUP_DIR
BACKUP_FILE="$BACKUP_DIR/db_backup_$(date +%Y%m%d_%H%M%S).sql"

if [ -z "$DB_PASS" ]; then
    mysqldump -u $DB_USER $DB_NAME > $BACKUP_FILE
else
    mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_FILE
fi

gzip $BACKUP_FILE
echo -e "${GREEN}✓ Database backup created: ${BACKUP_FILE}.gz${NC}"
echo ""

# Step 2: Install dependencies
echo -e "${YELLOW}[2/8] Installing dependencies...${NC}"
composer install --no-dev --no-interaction
echo -e "${GREEN}✓ Dependencies installed${NC}"
echo ""

# Step 3: Run migrations
echo -e "${YELLOW}[3/8] Running database migrations...${NC}"
php artisan migrate --force
echo -e "${GREEN}✓ Migrations completed${NC}"
echo ""

# Step 4: Seed website settings
echo -e "${YELLOW}[4/8] Seeding website settings...${NC}"
php artisan db:seed --class=WebsiteSettingSeeder --force
echo -e "${GREEN}✓ Website settings seeded${NC}"
echo ""

# Step 5: Setup storage symlink
echo -e "${YELLOW}[5/8] Setting up storage symlink...${NC}"
php artisan storage:link || true
echo -e "${GREEN}✓ Storage symlink setup${NC}"
echo ""

# Step 6: Clear all caches
echo -e "${YELLOW}[6/8] Clearing caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo -e "${GREEN}✓ Caches cleared${NC}"
echo ""

# Step 7: Set permissions
echo -e "${YELLOW}[7/8] Setting file permissions...${NC}"
chmod -R 775 storage/ bootstrap/cache/ public/storage/
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

# Step 8: Summary
echo -e "${YELLOW}[8/8] Deployment Summary${NC}"
echo -e "${GREEN}✓ Database backed up${NC}"
echo -e "${GREEN}✓ Dependencies installed${NC}"
echo -e "${GREEN}✓ Migrations ran${NC}"
echo -e "${GREEN}✓ Website settings seeded${NC}"
echo -e "${GREEN}✓ Storage configured${NC}"
echo -e "${GREEN}✓ Caches cleared${NC}"
echo ""

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  ✓ DEPLOYMENT COMPLETED SUCCESSFULLY${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "1. Test the application at https://igrasumut.com"
echo "2. Check database: SELECT * FROM website_settings LIMIT 1;"
echo "3. Check logs: tail -f storage/logs/laravel.log"
echo ""

