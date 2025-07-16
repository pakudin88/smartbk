# ✅ SISTEM REDIRECT SMART BOOKKEEPING - PANDUAN LENGKAP

## 🎯 OVERVIEW SISTEM

Sistem ini memungkinkan akses aplikasi menggunakan **URL bersih tanpa port** yang akan otomatis diredirect ke port yang sesuai.

### 📋 URL MAPPING

| Portal | URL Bersih | Redirect ke | Aplikasi |
|--------|------------|-------------|----------|
| **Portal Utama** | `http://localhost/smartbk` | - | Portal Selection |
| **Portal Guru** | `http://localhost/smartbk/guru` | `http://localhost:8081` | app-guru |
| **Portal Orang Tua** | `http://localhost/smartbk/ortu` | `http://localhost:8080` | app-ortu |
| **Portal Admin** | `http://localhost/smartbk/admin` | `http://localhost:8082` | app-superadmin |

## 🚀 CARA MENJALANKAN SISTEM

### Method 1: Otomatis (Recommended)
```batch
# 1. Buka Command Prompt di direktori smartbk
cd C:\xampp\htdocs\smartbk

# 2. Jalankan script otomatis
start-all-servers.bat

# 3. Akses portal utama
http://localhost/smartbk
```

### Method 2: Manual Step by Step
```batch
# 1. Start Apache di XAMPP Control Panel

# 2. Terminal 1 - app-ortu
cd C:\xampp\htdocs\smartbk\app-ortu
php spark serve --port=8080

# 3. Terminal 2 - app-guru  
cd C:\xampp\htdocs\smartbk\app-guru
php spark serve --port=8081

# 4. Terminal 3 - app-superadmin (optional)
cd C:\xampp\htdocs\smartbk\app-superadmin
php spark serve --port=8082

# 5. Buka browser
http://localhost/smartbk
```

## 🔧 FILE KONFIGURASI

### 1. `.htaccess` (Root Level)
```apache
RewriteEngine On

# Redirect rules untuk aplikasi
RewriteRule ^guru/?(.*)$ http://localhost:8081/$1 [R=301,L]
RewriteRule ^app-guru/?(.*)$ http://localhost:8081/$1 [R=301,L]
RewriteRule ^teacher/?(.*)$ http://localhost:8081/$1 [R=301,L]

RewriteRule ^ortu/?(.*)$ http://localhost:8080/$1 [R=301,L]
RewriteRule ^app-ortu/?(.*)$ http://localhost:8080/$1 [R=301,L]
RewriteRule ^parent/?(.*)$ http://localhost:8080/$1 [R=301,L]

RewriteRule ^admin/?(.*)$ http://localhost:8082/$1 [R=301,L]
RewriteRule ^app-superadmin/?(.*)$ http://localhost:8082/$1 [R=301,L]
RewriteRule ^superadmin/?(.*)$ http://localhost:8082/$1 [R=301,L]
```

### 2. `index.html` (Portal Selection)
Interface utama dengan 3 pilihan portal dan fitur redirect otomatis.

### 3. `start-all-servers.bat` (Auto Launcher)
Script untuk menjalankan semua server dalam sekali klik.

## 🎮 CARA PENGGUNAAN

### Step 1: Akses Portal Utama
```
http://localhost/smartbk
```
- Akan menampilkan 3 pilihan portal
- Klik portal yang diinginkan
- Otomatis redirect ke aplikasi yang sesuai

### Step 2: Akses Direct dengan URL Alias
```
http://localhost/smartbk/guru     → Redirect ke app-guru (8081)
http://localhost/smartbk/teacher  → Alias untuk guru
http://localhost/smartbk/ortu     → Redirect ke app-ortu (8080)
http://localhost/smartbk/parent   → Alias untuk ortu  
http://localhost/smartbk/admin    → Redirect ke app-superadmin (8082)
```

### Step 3: Login ke Aplikasi
**Portal Guru (8081):**
- Username: `guru_mtk`
- Password: `guru123`

**Portal Orang Tua (8080):**
- Username: `ortu_siswa1`
- Password: `ortu123`

## 🔍 TESTING & TROUBLESHOOTING

### 1. Test Manual
```batch
# Buka browser dan test URL berikut:
http://localhost/smartbk          # Portal utama
http://localhost/smartbk/guru     # Redirect ke 8081
http://localhost/smartbk/ortu     # Redirect ke 8080
http://localhost/smartbk/admin    # Redirect ke 8082
```

### 2. Test Page
```
http://localhost/smartbk/test-redirect.html
```
- Interface testing lengkap
- Status checker otomatis
- Command reference

### 3. Troubleshooting Common Issues

#### ❌ "Site can't be reached"
```batch
# Check Apache status
net start | findstr Apache

# Start Apache if not running
net start apache2.4
```

#### ❌ "Port already in use"
```batch
# Check port usage
netstat -an | findstr 808

# Kill process if needed
taskkill /f /im php.exe
```

#### ❌ "Redirect not working"
```batch
# Check .htaccess exists
dir .htaccess

# Check mod_rewrite enabled in Apache
# Edit httpd.conf: uncomment LoadModule rewrite_module
```

#### ❌ "CodeIgniter error"
```batch
# Check environment file
cd app-guru
type .env | findstr CI_ENVIRONMENT

# Clear cache
php spark cache:clear
```

## 📊 MONITORING & LOGS

### Check Server Status
```batch
# Manual check
curl http://localhost:8080/
curl http://localhost:8081/
curl http://localhost:8082/

# Windows alternative
powershell -Command "Invoke-WebRequest http://localhost:8080"
```

### Log Files
```
Apache Error Log: C:\xampp\apache\logs\error.log
CodeIgniter Logs: app-*/writable/logs/log-*.php
```

## 🚀 PRODUCTION DEPLOYMENT

### 1. Domain Configuration
```apache
# Replace localhost with actual domain
RewriteRule ^guru/?(.*)$ https://guru.yourdomain.com/$1 [R=301,L]
RewriteRule ^ortu/?(.*)$ https://ortu.yourdomain.com/$1 [R=301,L]
```

### 2. SSL Setup
```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 3. Security Headers
```apache
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-Content-Type-Options "nosniff"
Header always set X-XSS-Protection "1; mode=block"
```

## 📋 CHECKLIST DEPLOYMENT

### ✅ Prerequisites
- [ ] XAMPP installed with Apache & MySQL
- [ ] PHP 8.1+ available
- [ ] CodeIgniter 4.4.8 in each app folder
- [ ] Database configured in .env files

### ✅ File Structure
```
C:\xampp\htdocs\smartbk\
├── .htaccess                    # Redirect rules
├── index.html                   # Portal selection
├── start-all-servers.bat        # Auto launcher
├── test-redirect.html           # Testing page
├── error-404.html              # Error handling
├── app-guru/                   # Teacher app (8081)
├── app-ortu/                   # Parent app (8080)
└── app-superadmin/             # Admin app (8082)
```

### ✅ Testing Checklist
- [ ] Apache running on port 80
- [ ] Portal utama accessible: `http://localhost/smartbk`
- [ ] Guru redirect working: `http://localhost/smartbk/guru`
- [ ] Ortu redirect working: `http://localhost/smartbk/ortu`
- [ ] Login guru berhasil: `guru_mtk/guru123`
- [ ] Login ortu berhasil: `ortu_siswa1/ortu123`

## 🎯 BENEFITS

### ✅ User Experience
- **URL yang mudah diingat** (tanpa port)
- **Interface portal selection** yang user-friendly
- **Loading animation** saat redirect
- **Error handling** yang proper

### ✅ Technical Benefits
- **Clean URL structure** untuk SEO
- **Portable configuration** untuk different environments
- **Centralized routing** melalui .htaccess
- **Independent app deployment**

### ✅ Development Benefits
- **Easy testing** dengan multiple URLs
- **Flexible port management**
- **Scalable architecture** untuk additional apps
- **Consistent naming convention**

## 📞 SUPPORT & CONTACT

### Quick Help
```batch
# Emergency reset
cd C:\xampp\htdocs\smartbk
taskkill /f /im php.exe
start-all-servers.bat
```

### Documentation Files
- `REDIRECT_SYSTEM_GUIDE.md` - Technical documentation
- `test-redirect.html` - Interactive testing
- `README.md` - Basic information

---

**🎉 Smart BookKeeping Multi-App System v1.0**  
*Sistem redirect sukses diimplementasikan!*

**Next Steps:**
1. Jalankan `start-all-servers.bat`
2. Buka `http://localhost/smartbk`
3. Pilih portal dan test login
4. Enjoy the clean URL experience! 🚀
