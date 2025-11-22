# 🔧 SSH CONNECTION TROUBLESHOOTING

**Status**: Connection issue detected
**Date**: November 22, 2025

---

## ℹ️ SSH CREDENTIALS RECEIVED

```
SSH Host: dream.jagoanhosting.id
Username: igrasumu
Password: S3fr1f@dhl@n

Database Name: igrasumu_rapor
DB Username: igrasumu_sefri
DB Password: S3frifadhlan

Application Folder: /public_html
```

---

## 🔴 PROBLEM DETECTED

SSH connection attempts failed with **"Operation timed out"**:
- ❌ Port 22: Timeout
- ❌ Port 2222: Timeout

This means either:
1. Firewall blocking SSH ports
2. SSH service not running on server
3. SSH credentials format needs correction
4. Server misconfiguration

---

## ✅ SOLUTION - CONTACT JAGOANHOSTING

**Please contact JagoanHosting support dengan pertanyaan ini:**

```
Subject: SSH Access Not Working - Please Help

Hi JagoanHosting Support,

I received SSH credentials to connect:
- Username: igrasumu
- Host: dream.jagoanhosting.id
- Password: S3fr1f@dhl@n

But I cannot connect via SSH using:
  ssh igrasumu@dream.jagoanhosting.id

Getting error: "Operation timed out"

Please help me with:

1. Is SSH access enabled for my account?

2. What is the correct SSH connection command?
   (including correct host, port, and any special settings)

3. What SSH port should I use?
   (22, 2222, or other?)

4. Do I need to use a different hostname?

5. Is there a firewall rule I need to configure?

6. Can you test the SSH connection from your end?

Thank you,
[Your Name]
```

---

## 🎯 ALTERNATIVE SOLUTION - USE SFTP

If SSH doesn't work, you can use **SFTP** (SSH File Transfer Protocol):

```bash
# SFTP alternative (if SSH fails)
sftp -P 22 igrasumu@dream.jagoanhosting.id
# or port 2222:
sftp -P 2222 igrasumu@dream.jagoanhosting.id
```

---

## 📝 WHAT TO DO NOW

### **Option A: Wait for JagoanHosting Response** ⏳
1. Send support email (use template above)
2. Wait for their SSH setup instructions
3. Once they provide correct port/host, we'll test again

### **Option B: Use cPanel File Manager** 🖥️
Meanwhile, you can deploy manually via cPanel:

1. Login to cPanel: https://dream.jagoanhosting.id:2083/
2. Use File Manager to upload code
3. Use Terminal in cPanel to run commands

---

## 📋 ALTERNATIVE DEPLOYMENT APPROACH (If SSH Doesn't Work)

While waiting for SSH to work, here's a temporary workaround:

### **Using cPanel Terminal:**

1. **Login to cPanel**
   - URL: https://dream.jagoanhosting.id:2083/
   - Username: igrasumu
   - Password: S3fr1f@dhl@n

2. **Open Terminal** (in cPanel)
   - Click "Terminal" icon
   - You get shell access

3. **Clone repository**
   ```bash
   cd /public_html
   git clone https://github.com/pt-medan/rapor-igra-sumut.git temp-app
   cp -r temp-app/* ./
   rm -rf temp-app
   ```

4. **Run deployment**
   ```bash
   ./deploy.sh
   ```

---

## 🔍 DEBUGGING CHECKLIST

While troubleshooting SSH:

- [ ] Verify hostname: `dream.jagoanhosting.id`
- [ ] Verify username: `igrasumu`
- [ ] Verify password: `S3fr1f@dhl@n`
- [ ] Check if port 22 is open
- [ ] Check if port 2222 is open
- [ ] Ask if SSH is enabled on account
- [ ] Ask for correct SSH command
- [ ] Ask if firewall needs config

---

## 📞 JAGOANHOSTING SUPPORT

**Contact Information:**
- **Email**: Biasanya support@jagoanhosting.com
- **Chat**: Via cPanel
- **Phone**: Check their website

**When contacting:**
- Be clear about the issue
- Provide username: `igrasumu`
- Ask specifically about SSH setup
- Ask for exact connection command

---

## 🛠️ NEXT STEPS

### **Immediate (Today):**
1. Contact JagoanHosting support
2. Ask for correct SSH setup

### **Short Term (This Week):**
1. Get working SSH command
2. Test connection
3. Verify server tools

### **Alternative (Use cPanel):**
1. Access cPanel Terminal
2. Clone & deploy via Terminal
3. Don't wait for SSH if Terminal works

---

## 💡 PRO TIP

Many hosting providers restrict SSH access. If SSH truly doesn't work:

**Use this workaround:**
```bash
# Via cPanel Terminal instead:
cd /public_html
git clone ...
php artisan ...
```

This accomplishes the same thing as SSH!

---

## ✅ ACTION ITEMS

- [ ] **Contact JagoanHosting** with the email template above
- [ ] **Ask for correct SSH command**
- [ ] **OR access cPanel Terminal** as alternative
- [ ] **Report back** once you have either:
  - Working SSH command, OR
  - Confirmed cPanel Terminal access

---

**Status**: Waiting for JagoanHosting response
**Next**: Update SSH info once provided

