# PANDUAN TROUBLESHOOTING "WHOOPS!" ERROR - APP-ORTU

## Status Saat Ini: ✅ KONFIGURASI SUDAH BENAR

Berdasarkan analisis, konfigurasi environment Anda sudah benar:
- ✅ CI_ENVIRONMENT = development
- ✅ CI_DEBUG = true  
- ✅ Base URL sudah sesuai
- ✅ Database configuration ready

## Langkah Verifikasi Selanjutnya:

### 1. ✅ Cek PHP Extensions (WAJIB)
Buka Command Prompt dan jalankan:
```cmd
php -m | findstr /C:"intl" /C:"mbstring" /C:"json" /C:"mysqli"
```

Jika ada yang missing, edit `C:\xampp\php\php.ini`:
```ini
extension=intl
extension=mbstring  
extension=json
extension=mysqli
extension=curl
extension=fileinfo
extension=gd
```

Setelah edit php.ini, restart Apache di XAMPP Control Panel.

### 2. ✅ Cek Directory Permissions
Pastikan folder `writable` dan subfolder-nya bisa ditulis:
```cmd
cd c:\xampp\htdocs\smartbk\app-ortu
dir writable /s
```

### 3. ✅ Test Aplikasi Step-by-Step

#### A. Test PHP Extensions:
```cmd
cd c:\xampp\htdocs\smartbk\app-ortu
php debug-comprehensive.php
```

#### B. Test CodeIgniter Basic:
```cmd
php test-app-basic.php
```

#### C. Start Development Server:
```cmd
php spark serve --port=8080
```

#### D. Test di Browser:
- http://localhost:8080/ (Home page)
- http://localhost:8080/test (JSON response)

### 4. ✅ Jika Masih Error, Cek Log File
```cmd
type writable\logs\log-2025-07-14.log
```

### 5. ⚠️ Upgrade PHP (Sangat Disarankan)
PHP 8.0.30 sudah End-of-Life (November 2023).
Upgrade ke PHP 8.1+ untuk keamanan dan stabilitas.

## Files yang Sudah Dibuat untuk Testing:
- ✅ debug-comprehensive.php - Test lengkap sistem
- ✅ check-php-extensions.php - Cek ekstensi PHP  
- ✅ check-permissions.php - Cek hak akses folder
- ✅ test-app-basic.php - Test basic CodeIgniter

## Hasil yang Diharapkan:
Setelah verifikasi, Anda harus melihat:
- ✅ "App-Ortu is working! Welcome to Jendela Kemitraan"
- ✅ Tidak ada error "Whoops!"
- ✅ JSON response di /test endpoint

## Troubleshooting Cepat:
Jika masih error, langsung jalankan:
```cmd
cd c:\xampp\htdocs\smartbk\app-ortu
php spark serve --port=8080
```

Dan akses: http://localhost:8080/

Error detail akan muncul di Command Prompt karena mode development sudah aktif.

---
**Status**: Konfigurasi environment sudah optimal ✅
**Next Step**: Verifikasi PHP extensions dan test aplikasi 🚀
