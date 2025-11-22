# Email & Forgot Password Configuration

## Email Setup for Development

### Current Configuration
```env
MAIL_MAILER=log
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=noreply@rapor-igra.test
MAIL_FROM_NAME="Rapor IGRA"
```

### How It Works

**MAIL_MAILER=log** means:
- Emails are NOT actually sent
- Instead, they are logged to `storage/logs/laravel.log`
- This is perfect for development/testing
- You can view the entire email content (including reset links) in the log file

### To View Sent Emails

```bash
# View the last emails sent
tail -f storage/logs/laravel.log | grep -i "password\|mail\|reset"

# Or check the entire log
tail -100 storage/logs/laravel.log
```

In the logs you'll see the complete HTML email with the password reset link embedded.

### Setting Up Real Email for Production

#### Option 1: Using Gmail SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Rapor IGRA"
```

**Note:** Use [Google App Password](https://myaccount.google.com/apppasswords), not your regular password.

#### Option 2: Using Mailtrap (Recommended for Development)

Sign up at [Mailtrap](https://mailtrap.io) and get your credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Rapor IGRA"
```

All emails go to Mailtrap's web interface where you can view them.

#### Option 3: Using SendGrid

```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-sendgrid-api-key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Rapor IGRA"
```

## Forgot Password Flow

### User Experience

1. User clicks "Lupa kata sandi?" on login page
2. User is redirected to `/forgot-password`
3. User enters their email address
4. System sends password reset email
5. User receives email with reset link (or checks logs if using `MAIL_MAILER=log`)
6. User clicks reset link from email
7. User is redirected to `/reset-password/{token}?email={email}`
8. User enters new password (with visibility toggle)
9. User submits form
10. Password is reset and user is logged in

### Password Reset Security

- Reset tokens expire after **60 minutes**
- Tokens are hashed and stored securely
- One-time use only
- Email verification required
- Constant-time token comparison to prevent timing attacks

## Checking Email in Logs (Development)

The password reset link format:
```
http://localhost:8000/reset-password/{token}?email={email}
```

Example from laravel.log:
```html
<a href="http://localhost:8000/reset-password/ebcb18e3b4b89f6951f0e9fa348aac9fd53de39d74992c00645f872c2dbff7bb?email=user@example.com">
  Reset Password
</a>
```

Simply copy this URL into your browser address bar to test the reset flow.

## Indonesian Translations

All authentication pages now support Indonesian:

### Login Page (Halaman Login)
- Email → Email
- Password → Kata Sandi
- Remember me → Ingat saya
- Log in → Masuk
- Forgot your password? → Lupa kata sandi?

### Forgot Password Page (Halaman Lupa Kata Sandi)
- Lupa kata sandi? Tidak masalah. Cukup beri tahu kami alamat email Anda...
- Email Password Reset Link → Kirim Tautan Reset Kata Sandi

### Reset Password Page (Halaman Atur Ulang Kata Sandi)
- New Password → Kata Sandi Baru
- Confirm Password → Konfirmasi Kata Sandi
- Reset Password → Atur Ulang Kata Sandi

### Validation Messages
All validation messages are translated to Indonesian in `lang/id/validation.php`:
- Required field → wajib diisi
- Email format → berupa alamat email yang valid
- Password mismatch → tidak sesuai
- etc.

## Email Notifications

The password reset email is defined in:
- **Mailable**: `app/Mail/ResetPasswordNotification.php` (if using Mailable)
- **Notification**: `app/Notifications/ResetPasswordNotification.php` (if using Notification)

To customize the email appearance, check the respective file.

## Testing Checklist

- [ ] Development: Verify logs show email content
- [ ] Login page fully in Indonesian
- [ ] Forgot password page fully in Indonesian
- [ ] Reset password page fully in Indonesian with password toggle
- [ ] Form persistence works on forgot/reset pages
- [ ] Password toggle works on reset password page
- [ ] Token expires after 60 minutes
- [ ] One-time use of reset link enforced

## Troubleshooting

### Email not sending in production

1. Check mail configuration in `.env`
2. Verify credentials are correct
3. Check firewall/port settings
4. Enable debug: `MAIL_DEBUG=true`
5. Check server error logs: `storage/logs/laravel.log`

### Reset link expired

Reset links expire after 60 minutes (configurable in `config/auth.php`):

```php
'passwords' => [
    'default' => [
        'expire' => 60, // minutes
        'throttle' => 60, // seconds
    ],
],
```

### Reset link not working

- Verify email matches the one used to register
- Check token hasn't been modified
- Ensure 60-minute window hasn't passed
- Try in incognito/private browsing mode
- Clear cookies and try again
