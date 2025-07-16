# Smart BookKeeping - Sistem Redirect Portal

## 📋 Deskripsi Sistem

Sistem ini memungkinkan penggunaan URL biasa tanpa port yang akan otomatis diredirect ke aplikasi yang sesuai berdasarkan folder yang diakses.

## 🌐 URL Routing

### Portal Utama
- **URL**: `http://localhost/smartbk`
- **Deskripsi**: Halaman utama untuk memilih portal
- **Port**: Apache default (80)

### Portal Guru
- **URL**: `http://localhost/smartbk/guru`
- **Alias**: `/teacher`, `/app-guru`
- **Redirect ke**: `http://localhost:8081`
- **Aplikasi**: app-guru

### Portal Orang Tua
- **URL**: `http://localhost/smartbk/ortu`
- **Alias**: `/parent`, `/app-ortu`
- **Redirect ke**: `http://localhost:8080`
- **Aplikasi**: app-ortu

### Portal Super Admin
- **URL**: `http://localhost/smartbk/admin`
- **Alias**: `/superadmin`, `/app-superadmin`
- **Redirect ke**: `http://localhost:8082`
- **Aplikasi**: app-superadmin

## 🚀 Cara Menjalankan

### 1. Otomatis (Recommended)
```batch
# Jalankan script untuk start semua server
start-all-servers.bat
```

### 2. Manual
```batch
# Terminal 1 - app-ortu
cd app-ortu
php spark serve --port=8080

# Terminal 2 - app-guru  
cd app-guru
php spark serve --port=8081

# Terminal 3 - app-superadmin (jika ada)
cd app-superadmin
php spark serve --port=8082

# Pastikan Apache juga berjalan untuk redirect
```

## 🔧 Konfigurasi File

### 1. .htaccess
File utama untuk handling redirect:
```apache
# Redirect rules
RewriteRule ^guru/?(.*)$ http://localhost:8081/$1 [R=301,L]
RewriteRule ^ortu/?(.*)$ http://localhost:8080/$1 [R=301,L]
RewriteRule ^admin/?(.*)$ http://localhost:8082/$1 [R=301,L]
```

### 2. index.html
Portal utama dengan interface untuk memilih aplikasi

### 3. start-all-servers.bat
Script otomatis untuk menjalankan semua server

## 📱 Fitur Utama

### ✅ URL Bersih
- Tidak perlu ingat port number
- URL yang mudah diingat
- Konsisten dengan struktur folder

### ✅ Auto Redirect
- Redirect otomatis ke port yang tepat
- Handling error 404 dengan baik
- Loading animation saat redirect

### ✅ Multi-Application Support
- Support untuk 3 aplikasi berbeda
- Routing API terpisah
- Independent deployment

### ✅ User-Friendly Interface
- Portal selection page
- Visual indicators untuk setiap role
- Responsive design

## 🛠 Troubleshooting

### Port Sudah Digunakan
```bash
# Check port usage
netstat -an | findstr 808
```

### Apache Tidak Berjalan
```bash
# Start Apache via XAMPP
net start apache2.4
```

### Redirect Tidak Bekerja
1. Pastikan file `.htaccess` ada di root smartbk
2. Pastikan mod_rewrite enabled di Apache
3. Check Apache error log

## 📊 Status Monitoring

### Cek Status Server
- **app-ortu**: `http://localhost:8080`
- **app-guru**: `http://localhost:8081`
- **app-superadmin**: `http://localhost:8082`

### Cek Redirect
- Test URL: `http://localhost/smartbk/guru`
- Harus redirect ke: `http://localhost:8081`

## 🔒 Security Features

### Headers Security
```apache
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-Content-Type-Options "nosniff"
Header always set X-XSS-Protection "1; mode=block"
```

### CORS Policy
```apache
Header always set Access-Control-Allow-Origin "*"
```

## 📝 Log Files

### Apache Error Log
```
C:\xampp\apache\logs\error.log
```

### CodeIgniter Logs
```
app-guru/writable/logs/
app-ortu/writable/logs/
app-superadmin/writable/logs/
```

## 🎯 Testing URLs

### Manual Testing
1. `http://localhost/smartbk` → Portal utama
2. `http://localhost/smartbk/guru` → Redirect ke 8081
3. `http://localhost/smartbk/ortu` → Redirect ke 8080
4. `http://localhost/smartbk/admin` → Redirect ke 8082

### API Testing
1. `http://localhost/smartbk/api/guru/test` → API guru
2. `http://localhost/smartbk/api/ortu/test` → API ortu
3. `http://localhost/smartbk/api/admin/test` → API admin

## 📋 Requirements

### Software
- XAMPP dengan Apache & MySQL
- PHP 8.1+
- CodeIgniter 4.4.8
- Web Browser modern

### Port Requirements
- **80**: Apache (default)
- **8080**: app-ortu
- **8081**: app-guru  
- **8082**: app-superadmin

## 🚀 Production Deployment

### Domain Setup
```apache
# Ganti localhost dengan domain
RewriteRule ^guru/?(.*)$ http://guru.smartbookkeeping.com/$1 [R=301,L]
RewriteRule ^ortu/?(.*)$ http://ortu.smartbookkeeping.com/$1 [R=301,L]
```

### SSL Configuration
```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## 📞 Support

Untuk pertanyaan atau masalah:
- Check troubleshooting section
- Review Apache error logs
- Test individual applications first
- Verify port availability

---

**Smart BookKeeping v1.0**  
*Sistem Manajemen Sekolah Terpadu*
