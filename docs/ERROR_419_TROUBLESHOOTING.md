# Error 419 (Page Expired) - Troubleshooting Guide

## Apa itu Error 419?

**HTTP 419 "Page Expired"** adalah error CSRF (Cross-Site Request Forgery) token yang tidak valid atau sudah expired. Ini terjadi ketika:

1. **CSRF Token tidak cocok** antara form dan session
2. **Session sudah expired** (timeout)
3. **Session data tidak konsisten** antara server dan client
4. **Multiple tab/window** membuat session conflicting
5. **Cache browser** menyebabkan stale CSRF token

---

## Penyebab Error 419 Sering Terjadi

### 1. **Session Timeout (Paling Umum)**
```
Durasi: 720 menit (12 jam)
Namun dalam praktik:
- Jika browser ditutup → session mungkin hilang
- Jika idle terlalu lama → session di-clean garbage collection
- Database session table penuh → session lama dihapus
```

### 2. **Session Garbage Collection**
```
Config: session.lottery = [2, 100]
Artinya: 2% dari request akan trigger session cleanup
Random timing → session bisa terhapus kapan saja
```

### 3. **CSRF Token Mismatch**
```
Penyebab:
- Form cache dari request sebelumnya
- Multiple browser tabs dengan session berbeda
- Page refresh di tengah submit form
- Token regenerate saat logout
```

### 4. **Browser Cache Issues**
```
Form HTML di-cache browser
CSRF token di form sudah expired
Browser ngga refresh token saat load halaman
```

### 5. **Database Session Issues**
```
- Sessions table corrupted
- Sessions table penuh
- Database connection timeout
- Disk space penuh
```

### 6. **Middleware Execution Order**
```
EnsureGuruIsValidated middleware:
- Invalidate session
- Regenerate token
- Redirect ke login
→ Bisa cause 419 jika timing salah
```

---

## Current Configuration

### Session Settings (`.env`)
```
SESSION_DRIVER=database         ✓ Using database (better than file)
SESSION_LIFETIME=720            ✓ 12 hours (long timeout)
SESSION_EXPIRE_ON_CLOSE=false   ✓ Keep after browser close
```

### Session Config (`config/session.php`)
```
'driver' => 'database'
'lifetime' => 720 minutes
'expire_on_close' => false
'cookie' => 'rapor-igrav-local-dev-session'
'same_site' => 'lax'           ✓ Good for CSRF protection
'http_only' => true             ✓ JS tidak bisa akses cookie
'secure' => null                ⚠ NULL di development (OK)
```

### Middleware
```
- All routes protected by web middleware (includes CSRF verification)
- EnsureGuruIsValidated appended globally
- Auth routes in 'guest' middleware (tidak perlu CSRF)
```

---

## Kenapa Error 419 Tetap Terjadi?

### Problem 1: Session Garbage Collection
**Masalah:**
```
Lottery: [2, 100] = 2% chance setiap request
Session lifetime: 720 menit
Tapi:
- Garbage collection 99% jarang trigger
- Session bisa tetap di DB meski expired
- Session file tidak di-cleanup otomatis
```

**Solusi:**
Increase lottery probability atau manual cleanup

### Problem 2: Multiple Requests During Session Invalidation
**Masalah:**
```
1. User login ✓ (session created, CSRF token generated)
2. EnsureGuruIsValidated check guru status
3. Jika pending: invalidate session + regenerate token
4. Redirect ke login
5. User refresh form login
6. Browser POST dengan OLD CSRF token → 419!
```

### Problem 3: Development Environment Issues
**Masalah:**
```
- Database sessions bisa inconsistent
- File permissions issues
- Clock skew antara requests
```

---

## Solusi Implementasi

### 1. **Increase Session Garbage Collection**
Ubah di `config/session.php`:
```php
'lottery' => [10, 100],  // 10% instead of 2%
```

### 2. **Add Session Cleanup Command**
```php
// app/Console/Commands/CleanupSessions.php
public function handle()
{
    DB::table('sessions')
        ->where('last_activity', '<', now()->subMinutes(720)->timestamp)
        ->delete();
}
```

Schedule di `app/Console/Kernel.php`:
```php
$schedule->command('session:cleanup')
    ->everyFiveMinutes();
```

### 3. **Better Error Handling**
```blade
<!-- resources/views/auth/login.blade.php -->
@if ($errors->has('419'))
    <div class="alert alert-warning">
        Session expired. Please try again.
    </div>
@endif
```

### 4. **Client-Side Token Refresh**
```javascript
// public/js/csrf-token-refresh.js
document.addEventListener('DOMContentLoaded', function() {
    // Refresh CSRF token sebelum submit form
    const forms = document.querySelectorAll('form[method="POST"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Update token dari page meta
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            const input = this.querySelector('input[name="_token"]');
            
            if (token && input) {
                input.value = token;
            }
        });
    });
});
```

### 5. **Session Persistence Script**
```javascript
// public/js/session-keeper.js
// Keep session alive dengan ping setiap 30 menit
setInterval(() => {
    fetch('/api/heartbeat')
        .then(r => r.json())
        .catch(e => console.log('Heartbeat failed:', e));
}, 30 * 60 * 1000);
```

### 6. **CSRF Token in Meta Tag**
```blade
<!-- resources/views/layouts/app.blade.php -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // Automatically set CSRF token untuk AJAX
    fetch('/any-route', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
</script>
```

---

## Debugging Steps

### 1. Check Session Database
```bash
# Check sessions table
php artisan tinker

# Count active sessions
DB::table('sessions')->count();

# Find expired sessions
DB::table('sessions')
    ->where('last_activity', '<', now()->subMinutes(720)->timestamp)
    ->count();

# Check for specific user session
DB::table('sessions')
    ->where('user_id', 123)
    ->get();
```

### 2. Check CSRF Token
```php
// In login form
// Should match between form and session
$token = csrf_token();
session('CSRF_TOKEN');
```

### 3. Browser DevTools
```
1. Open DevTools → Application → Cookies
2. Find "rapor-igrav-local-dev-session" cookie
3. Check: Value, Expiration, Domain, Path, SameSite
4. In Network tab: Check response headers for Set-Cookie
```

### 4. Check Logs
```bash
tail -f storage/logs/laravel.log | grep -i "419\|csrf\|session"
```

### 5. Clear Session Cache
```bash
# Clear all sessions
php artisan session:clear

# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Restart database connection
```

---

## Recommended Fixes (Priority Order)

### ⭐ Priority 1: Improve Session Cleanup
**Action:**
1. Increase lottery to [10, 100]
2. Add scheduled session cleanup command
3. Monitor sessions table size

**Why:**
- Most effective for production
- Prevents expired sessions accumulating
- Reduces database bloat

### ⭐ Priority 2: Add Heartbeat Route
**Action:**
1. Create lightweight `/api/heartbeat` route
2. Add JavaScript to ping every 30 minutes
3. Keep user session alive during browsing

**Why:**
- Prevents timeout during active use
- Simple to implement
- Works across page navigations

### ⭐ Priority 3: Better Error Messages
**Action:**
1. Catch 419 errors gracefully
2. Show user-friendly message
3. Auto-redirect to login
4. Suggest browser cache clear

**Why:**
- Better UX
- Helps users understand issue
- Provides troubleshooting steps

### Priority 4: Client-Side Token Management
**Action:**
1. Refresh CSRF token before form submit
2. Store token in meta tag
3. Auto-update on page load

**Why:**
- Extra safety layer
- Reduces token mismatch issues
- More resilient

---

## Testing Checklist

- [ ] Open login page
- [ ] Inspect CSRF token in form
- [ ] Wait 5+ minutes
- [ ] Refresh page
- [ ] Try login
- [ ] Check if error 419 appears

**Expected:** Should login successfully (session valid 12 hours)

- [ ] Open login in 2 tabs
- [ ] Login in tab 1
- [ ] Try login in tab 2
- [ ] Check for errors

**Expected:** Both should work (separate sessions)

- [ ] Open login page
- [ ] Open DevTools Console
- [ ] Execute: `document.querySelector('input[name="_token"]').value`
- [ ] Refresh page
- [ ] Execute same command again
- [ ] Compare values

**Expected:** Tokens should be identical

---

## Production Recommendations

```php
// config/session.php for production

return [
    'driver' => 'database',
    'lifetime' => 480,              // 8 hours instead of 12
    'expire_on_close' => false,
    'lottery' => [10, 100],         // Increase garbage collection
    'same_site' => 'strict',        // Stricter CSRF
    'secure' => true,               // HTTPS only
    'http_only' => true,            // No JavaScript access
];
```

```php
// database/migrations create session cleanup migration
Schema::table('sessions', function (Blueprint $table) {
    $table->index('last_activity');
});

// Automatic cleanup via scheduler
protected function schedule(Schedule $schedule)
{
    $schedule->command('session:cleanup')->hourly();
}
```

---

## FAQ

### Q: Mengapa user sering dapat error 419?
**A:** Kemungkinan:
1. Session cleanup terlalu agresif
2. Multiple browser tabs conflict
3. Network latency session desync
4. Browser cache stale token

### Q: Apa bedanya dengan 401/403?
**A:**
- **401 Unauthorized**: User belum login atau token invalid
- **403 Forbidden**: User tidak punya permission
- **419 Page Expired**: CSRF token expired/invalid

### Q: Bagaimana prevent 419 di production?
**A:**
1. Use Redis for sessions (faster, more reliable)
2. Implement heartbeat mechanism
3. Increase garbage collection
4. Monitor session table size
5. Use CDN for static assets

### Q: Apakah 419 bisa dihilangkan selamanya?
**A:** Tidak 100%, tapi bisa minimize:
- Proper session management
- Regular cleanup
- Heartbeat mechanism
- Better error handling
- User education

---

## Related Files

- `.env` - Session configuration
- `config/session.php` - Session driver settings
- `routes/auth.php` - Auth routes (guest middleware)
- `app/Http/Middleware/EnsureGuruIsValidated.php` - Session invalidation
- `resources/views/auth/login.blade.php` - Login form (has @csrf)

---

## Commit History

- **Commit 18**: Fixed 419 with SESSION_DRIVER=database, SESSION_LIFETIME=720
- **Commit 22**: Added dynamic favicon loading (unrelated)
- **Commit 23**: (This document) - Comprehensive 419 debugging guide

---

**Last Updated**: November 22, 2025  
**Status**: Documentation Only (No Code Changes)  
**Version**: 1.0
