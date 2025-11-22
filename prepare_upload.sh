#!/bin/bash

# ========================================
# PREPARE PROJECT FOR UPLOAD
# Untuk: Jagoan Hosting (igrasumut.com)
# ========================================

echo "🚀 Starting Rapor IGRAV2 Production Preparation..."
echo ""

PROJECT_DIR="/Users/macbook/Desktop/rapor_igrav2"
UPLOAD_DIR="$HOME/Desktop/rapor_upload"
BACKUP_DIR="$HOME/Desktop/rapor_backup"

# ========================================
# STEP 1: Create Backup
# ========================================
echo "📦 Step 1: Creating backup..."
mkdir -p "$BACKUP_DIR"
cp -r "$PROJECT_DIR" "$BACKUP_DIR/rapor_igrav_backup_$(date +%Y%m%d_%H%M%S)"
echo "✓ Backup created: $BACKUP_DIR"
echo ""

# ========================================
# STEP 2: Build Assets
# ========================================
echo "🔨 Step 2: Building assets..."
cd "$PROJECT_DIR"

# Clear npm cache
npm cache clean --force

# Install dependencies
npm install
if [ $? -ne 0 ]; then
    echo "❌ npm install failed"
    exit 1
fi

# Build production
npm run build
if [ $? -ne 0 ]; then
    echo "❌ npm run build failed"
    exit 1
fi

echo "✓ Assets built successfully"
echo "✓ Check: public/build/ contains app.css, app.js, manifest.json"
ls -lah "$PROJECT_DIR/public/build/"
echo ""

# ========================================
# STEP 3: Prepare Upload Folder
# ========================================
echo "📁 Step 3: Preparing upload folder..."
rm -rf "$UPLOAD_DIR"
mkdir -p "$UPLOAD_DIR"

# Copy project excluding dev files
rsync -av \
  --exclude='.env.local' \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='vendor' \
  --exclude='.env' \
  --exclude='.env.*.php' \
  --exclude='*.md' \
  --exclude='.vscode' \
  --exclude='storage/logs/*.log' \
  "$PROJECT_DIR/" \
  "$UPLOAD_DIR/"

if [ $? -ne 0 ]; then
    echo "❌ rsync copy failed"
    exit 1
fi

echo "✓ Files copied to: $UPLOAD_DIR"
echo ""

# ========================================
# STEP 4: Copy .env.production
# ========================================
echo "⚙️  Step 4: Copying .env.production..."
if [ -f "$PROJECT_DIR/.env.production" ]; then
    cp "$PROJECT_DIR/.env.production" "$UPLOAD_DIR/.env.production"
    echo "✓ .env.production copied"
else
    echo "❌ .env.production not found!"
    exit 1
fi
echo ""

# ========================================
# STEP 5: Verify structure
# ========================================
echo "🔍 Step 5: Verifying upload structure..."
echo ""
echo "Top-level folders:"
ls -d "$UPLOAD_DIR"/*/ | head -10
echo ""
echo "File count:"
find "$UPLOAD_DIR" -type f | wc -l
echo ""
echo "Key files check:"
echo "  ☐ public/build/app.css: $([ -f "$UPLOAD_DIR/public/build/app.css" ] && echo '✓' || echo '❌')"
echo "  ☐ public/build/app.js: $([ -f "$UPLOAD_DIR/public/build/app.js" ] && echo '✓' || echo '❌')"
echo "  ☐ artisan: $([ -f "$UPLOAD_DIR/artisan" ] && echo '✓' || echo '❌')"
echo "  ☐ .env.production: $([ -f "$UPLOAD_DIR/.env.production" ] && echo '✓' || echo '❌')"
echo ""

# ========================================
# STEP 6: Create ZIP Archive
# ========================================
echo "📦 Step 6: Creating ZIP archive..."
cd "$HOME/Desktop"

# Remove old zip if exists
rm -f rapor_igrav_prod.zip

# Create new zip
zip -r rapor_igrav_prod.zip rapor_upload/ > /dev/null 2>&1

if [ -f "rapor_igrav_prod.zip" ]; then
    ZIP_SIZE=$(du -h rapor_igrav_prod.zip | cut -f1)
    echo "✓ ZIP created: $HOME/Desktop/rapor_igrav_prod.zip"
    echo "✓ Size: $ZIP_SIZE"
else
    echo "❌ ZIP creation failed"
    exit 1
fi
echo ""

# ========================================
# FINAL STATUS
# ========================================
echo "========================================="
echo "✅ PREPARATION COMPLETED SUCCESSFULLY"
echo "========================================="
echo ""
echo "📋 FILES READY FOR UPLOAD:"
echo "   ZIP: $HOME/Desktop/rapor_igrav_prod.zip ($ZIP_SIZE)"
echo "   FOLDER: $UPLOAD_DIR"
echo ""
echo "📝 NEXT STEPS:"
echo "   1. Read: UPLOAD_GUIDE_JAGOAN_HOSTING.md"
echo "   2. Login: https://dream.jagoanhosting.id:2083"
echo "   3. Create database (see guide)"
echo "   4. Upload ZIP file to /public_html"
echo "   5. Extract and move files"
echo "   6. Configure .env in server"
echo "   7. Run migrations"
echo "   8. Test in browser"
echo ""
echo "⚡ ESTIMATED TIME: 45 minutes"
echo ""
echo "========================================="
echo "🚀 Ready to upload! Follow UPLOAD_GUIDE_JAGOAN_HOSTING.md"
echo "========================================="
