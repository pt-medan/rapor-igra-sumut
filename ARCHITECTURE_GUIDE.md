# 🗺️ VISUAL DEPLOYMENT ARCHITECTURE

```
┌──────────────────────────────────────────────────────────────────┐
│                         YOUR WORKFLOW                            │
└──────────────────────────────────────────────────────────────────┘

┌─────────────────────────────┐
│    LOCAL DEVELOPMENT        │
│   (Macbook - Your PC)       │
├─────────────────────────────┤
│ - Create new features       │
│ - Test locally              │
│ - git add + git commit      │
│ - git push origin main      │
└──────────────┬──────────────┘
               │
               │ HTTPS/SSH
               ▼
┌─────────────────────────────┐
│   GITHUB REPOSITORY         │
│  (Cloud Version Control)    │
├─────────────────────────────┤
│ github.com/username/        │
│ rapor-igra-sumut            │
│                             │
│ Stores all code history     │
│ Accessible everywhere       │
└──────────────┬──────────────┘
               │
               │ git pull
               ▼
┌──────────────────────────────────────────────┐
│      PRODUCTION SERVER                       │
│       (JagoanHosting)                        │
├──────────────────────────────────────────────┤
│  Website: igrasumut.com                      │
│  Database: igrasumut_rapor                   │
│  Folder: /var/www/igrasumut.com              │
│                                              │
│  ┌────────────────────────────────────────┐  │
│  │  Files                                 │  │
│  │  ├── app/                              │  │
│  │  ├── database/                         │  │
│  │  ├── resources/                        │  │
│  │  ├── routes/                           │  │
│  │  ├── storage/app/public/website/ ◄─── │  │ Uploaded images
│  │  └── .env (production settings)        │  │
│  └────────────────────────────────────────┘  │
│                                              │
│  ┌────────────────────────────────────────┐  │
│  │  Database                              │  │
│  │  ├── users                             │  │
│  │  ├── gurus                             │  │
│  │  ├── siswas                            │  │
│  │  ├── sekolahs                          │  │
│  │  ├── penilaians                        │  │
│  │  └── website_settings ◄─── Logo, Favicon│
│  └────────────────────────────────────────┘  │
│                                              │
│  ┌────────────────────────────────────────┐  │
│  │  Backups (Automated 2 AM daily)        │  │
│  │  ├── db_backup_20250122_020000.sql.gz  │  │
│  │  ├── db_backup_20250123_020000.sql.gz  │  │
│  │  └── ... (30 hari, auto-delete)        │  │
│  └────────────────────────────────────────┘  │
│                                              │
│  Live Users                                  │
│  └── Akses igrasumut.com ──┐               │
│                            ▼               │
│                       [Nginx/Apache]       │
│                       [PHP-FPM]            │
│                       [Database]           │
│                            ▲               │
└────────────────────────────┼───────────────┘
                             │
                     🌐 Internet Users
                    (Guru, Admin, etc)
```

---

## 📋 FILE STRUCTURE SETELAH SETUP

```
rapor-igra-sumut/
├── .git/                          ← Git repository
├── .env                           ← Production credentials (ignore)
├── .env.example                   ← Template .env
├── .gitignore                     ← Tell git what to ignore
│
├── DEPLOYMENT_GUIDE.md            ← Panduan lengkap (baca ini!)
├── DEPLOYMENT_SUMMARY.md          ← Ringkasan & action items
├── QUICK_START.md                 ← Checklist praktis
│
├── deploy.sh                      ← Run: ./deploy.sh (automated)
├── backup_daily.sh                ← Setup di cron: 0 2 * * *
│
├── composer.json                  ← PHP dependencies
├── package.json                   ← JavaScript dependencies
│
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminWebsiteController.php    ← Admin branding management
│   │   ├── WelcomeController.php          ← Welcome page logic
│   │   └── ...
│   ├── Models/
│   │   ├── WebsiteSetting.php             ← Logo, Favicon, etc storage
│   │   └── ...
│   └── ...
│
├── database/
│   ├── migrations/
│   │   └── 2025_11_22_070349_create_website_settings_table.php
│   └── seeders/
│       └── WebsiteSettingSeeder.php        ← Initial data
│
├── resources/views/
│   ├── welcome.blade.php          ← Public landing page
│   ├── admin/website/
│   │   ├── index.blade.php        ← Admin dashboard
│   │   └── edit.blade.php         ← Admin edit form
│   ├── layouts/
│   │   ├── app.blade.php          ← Authenticated layout
│   │   └── navigation.blade.php   ← Header with logo
│   └── ...
│
├── routes/web.php                 ← URL routes configuration
├── config/                        ← Configuration files
├── storage/
│   └── app/public/website/        ← Uploaded logo, favicon, hero image
├── public/
│   ├── storage/ ──┐               ← Symlink to storage/app/public
│   └── ...        └──── (created by: php artisan storage:link)
│
└── ...other files...
```

---

## 🔐 DATABASE FLOW

```
Admin Upload Logo/Favicon
         │
         ▼
AdminWebsiteController@update
  ├─ Validate file
  ├─ Store to storage/app/public/website/
  └─ Save filename to database
         │
         ▼
WebsiteSetting Model
  └─ Record in table:
     ┌──────────────────────────────────┐
     │ id │ key        │ value          │
     ├──────────────────────────────────┤
     │ 1  │ app_name   │ E-Rapor IGRA   │
     │ 2  │ app_logo   │ website/...jpg │ ◄─ Filename
     │ 3  │ app_favicon│ website/...ico │ ◄─ Filename
     └──────────────────────────────────┘
         │
         ├────► Welcome Page
         │      ├─ Show logo di header
         │      └─ Favicon di tab browser
         │
         └────► Authenticated Pages
                ├─ Show logo di navigation
                └─ Favicon di tab browser
```

---

## 🔄 DEPLOYMENT SEQUENCE DIAGRAM

```
STEP 1: Local Development
┌─────────────────┐
│ Develop Feature │
└────────┬────────┘
         │
         ▼
┌──────────────────┐
│ Test Locally OK? │
└────────┬────────┘
         │ Yes
         ▼
┌────────────────────┐
│ git add .          │
│ git commit -m "xx" │
└────────┬───────────┘
         │
         ▼
┌──────────────────────┐
│ git push origin main │
└────────┬─────────────┘
         │
         ▼ Upload to GitHub


STEP 2: Production Deployment
┌──────────────────────┐
│ SSH to Server        │
│ ssh user@host        │
└────────┬─────────────┘
         │
         ▼
┌──────────────────────┐
│ cd /var/www/...      │
└────────┬─────────────┘
         │
         ▼
┌──────────────────────┐
│ Backup Database      │
│ (deploy.sh auto)     │
└────────┬─────────────┘
         │
         ▼
┌──────────────────────┐
│ git pull origin main │
└────────┬─────────────┘
         │
         ▼
┌──────────────────────┐
│ ./deploy.sh          │
│ ├─ composer install  │
│ ├─ migrations        │
│ ├─ seeders           │
│ └─ cache clear       │
└────────┬─────────────┘
         │
         ▼
┌──────────────────────┐
│ Test Website         │
│ Open igrasumut.com   │
└────────┬─────────────┘
         │
         ▼ All OK?
┌──────────────────────┐
│ ✅ DEPLOYMENT DONE   │
└──────────────────────┘
```

---

## 💾 BACKUP & RECOVERY FLOW

```
AUTOMATIC BACKUP (Every Day 2 AM via Cron)
┌─────────────────────────────────────────┐
│ 2:00 AM - Cron Job Triggered            │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ backup_daily.sh                         │
├─────────────────────────────────────────┤
│ 1. Dump database to SQL                 │
│ 2. Compress with gzip                   │
│ 3. Backup storage folder                │
│ 4. Delete backups >30 days               │
└────────────┬────────────────────────────┘
             │
             ▼
Backup Directory
/home/igrasumut/backups/
├── db_backup_20250122_020000.sql.gz     ✅
├── db_backup_20250123_020000.sql.gz     ✅
├── db_backup_20250124_020000.sql.gz     ✅
├── storage_backup_20250122_020000.tar.gz✅
└── ... (max 30 days)


IF DISASTER OCCURS:
┌──────────────────────────────────────┐
│ Error! Data Corrupt                  │
└────────┬─────────────────────────────┘
         │
         ▼
┌──────────────────────────────────────┐
│ 1. Find closest backup                │
│    ls -lah /backups/                  │
└────────┬─────────────────────────────┘
         │
         ▼
┌──────────────────────────────────────┐
│ 2. Restore database                   │
│ mysql < backup_20250123.sql.gz        │
└────────┬─────────────────────────────┘
         │
         ▼
┌──────────────────────────────────────┐
│ 3. Test & Verify                      │
│ ✅ Data Restored Successfully         │
└──────────────────────────────────────┘
```

---

## 🎯 SUMMARY

| Aspect | Before | After |
|--------|--------|-------|
| **Version Control** | ❌ None | ✅ Git + GitHub |
| **Deployment** | 🐌 Manual FTP | ⚡ Automated scripts |
| **Backup** | 📝 Manual PHPMyAdmin | 🔄 Auto daily 2 AM |
| **Recovery** | ❌ Difficult | ✅ One command restore |
| **Collaboration** | ❌ None | ✅ GitHub tracking |
| **Rollback** | ❌ Manual | ✅ git revert |
| **Documentation** | ❌ None | ✅ Comprehensive guides |

---

## ⏱️ TIMELINE

```
Week 1 (This Week):
├─ Monday-Wednesday: Setup Git & GitHub
├─ Thursday: SSH setup & first deployment
└─ Friday: Testing & backup setup

Week 2+:
├─ Regular development & commits
├─ Friday deployment (after testing)
└─ Auto-backup runs every night
```

---

**Status**: 🟢 READY FOR IMPLEMENTATION
**Complexity**: 🟢 BEGINNER FRIENDLY
**Time Estimate**: ⏱️ 30 minutes setup

