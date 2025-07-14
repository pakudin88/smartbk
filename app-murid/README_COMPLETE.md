# PANDUAN LENGKAP APLIKASI MURID - SIMAKLAH

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Cara Menjalankan](#cara-menjalankan)
3. [Fitur Safe Space](#fitur-safe-space)
4. [Akun Testing](#akun-testing)
5. [URL dan Endpoints](#url-dan-endpoints)
6. [Troubleshooting](#troubleshooting)
7. [File Structure](#file-structure)

---

## 🎯 Overview

Aplikasi Murid SIMAKLAH adalah platform khusus untuk siswa dengan fitur utama **"Safe Space"** - ruang aman untuk konseling, jurnal digital, dan dukungan kesehatan mental.

### Fitur Utama:
- ✅ **Authentication System** - Login/logout untuk murid
- ✅ **Safe Space Dashboard** - Portal utama ruang aman
- ✅ **Konsul Cepat & Anonim** - Chat konseling real-time
- ✅ **Jadwalkan Sesi Konseling** - Booking konseling dengan konselor
- ✅ **Jurnal Digital & Pelacak Emosi** - Jurnal harian dengan mood tracking
- ✅ **Pusat Informasi & Bantuan** - Resource dan artikel kesehatan mental

---

## 🚀 Cara Menjalankan

### Metode 1: Command Line
```bash
# Navigasi ke folder aplikasi
cd c:\xampp\htdocs\simaklah-main\app-murid

# Jalankan dengan port default (8080)
php spark serve

# Atau dengan port custom
php spark serve --port=9000
php spark serve --port=8082
php spark serve --port=3000
```

### Metode 2: Menggunakan Batch File
1. Double-click file `run-app-murid.bat`
2. Pilih port yang diinginkan
3. Aplikasi akan berjalan otomatis

### Metode 3: Manual Setup
1. Pastikan XAMPP running (Apache & MySQL)
2. Buka terminal di folder `app-murid`
3. Jalankan perintah `php spark serve --port=9000`
4. Akses http://localhost:9000

---

## 🏠 Fitur Safe Space

### 1. Dashboard Safe Space
- **URL**: `/safe-space/dashboard`
- **Fitur**: Overview semua fitur, statistik, quick access

### 2. Konsul Cepat & Anonim
- **URL**: `/safe-space/konsul-cepat`
- **Fitur**: 
  - Chat real-time dengan konselor
  - Mode anonim tersedia
  - Status online/offline konselor
  - History percakapan

### 3. Jadwalkan Sesi Konseling
- **URL**: `/safe-space/jadwal-konseling`
- **Fitur**:
  - Lihat slot konselor tersedia
  - Book sesi konseling
  - Kalender interaktif
  - History konseling

### 4. Jurnal Digital & Pelacak Emosi
- **URL**: `/safe-space/jurnal-digital`
- **Fitur**:
  - Tulis jurnal harian
  - Tracking mood/emosi (1-10)
  - Grafik visualisasi mood
  - Edit/hapus jurnal entry

### 5. Pusat Informasi & Bantuan
- **URL**: `/safe-space/pusat-informasi`
- **Fitur**:
  - Artikel kesehatan mental
  - Tips dan panduan
  - Resource bantuan
  - Search dan filter konten

---

## 👤 Akun Testing

### Sample Login Credentials:
| Username | Password | Nama Lengkap | NISN |
|----------|----------|--------------|------|
| ahmad.budi | 123456 | Ahmad Budi Santoso | 1234567890 |
| siti.aisyah | 123456 | Siti Aisyah Putri | 1234567891 |
| rudi.santoso | 123456 | Rudi Santoso | 1234567892 |
| maya.sari | 123456 | Maya Sari Dewi | 1234567893 |
| doni.pratama | 123456 | Doni Pratama | 1234567894 |

### Membuat Data Murid:
Jalankan file `setup-murid-data.php` untuk:
- Membuat tabel murid jika belum ada
- Menambah sample data murid
- Verifikasi data login

---

## 🔗 URL dan Endpoints

### Main Pages:
- **Root/Login**: `http://localhost:[PORT]/`
- **Dashboard**: `http://localhost:[PORT]/dashboard`
- **Logout**: `http://localhost:[PORT]/logout`

### Safe Space Pages:
- **Dashboard**: `http://localhost:[PORT]/safe-space/dashboard`
- **Konsul Cepat**: `http://localhost:[PORT]/safe-space/konsul-cepat`
- **Jadwal Konseling**: `http://localhost:[PORT]/safe-space/jadwal-konseling`
- **Jurnal Digital**: `http://localhost:[PORT]/safe-space/jurnal-digital`
- **Pusat Informasi**: `http://localhost:[PORT]/safe-space/pusat-informasi`

### API Endpoints:
- **POST** `/safe-space/api/send-message` - Kirim pesan chat
- **POST** `/safe-space/api/save-mood` - Simpan data mood
- **POST** `/safe-space/api/save-journal` - Simpan jurnal entry
- **POST** `/safe-space/api/request-counseling` - Request sesi konseling
- **GET** `/safe-space/api/get-mood-history` - Get history mood
- **GET** `/safe-space/api/get-journal-entries` - Get jurnal entries
- **GET** `/safe-space/api/get-available-slots` - Get slot konseling tersedia
- **GET** `/safe-space/api/get-counseling-history` - Get history konseling
- **GET** `/safe-space/api/get-info-content` - Get konten informasi

---

## 🛠 Troubleshooting

### Problem: Muncul Halaman Welcome CodeIgniter
**Solusi:**
```bash
# Pastikan di folder yang benar
cd c:\xampp\htdocs\simaklah-main\app-murid

# Clear cache
php spark cache:clear

# Cek routes
cat app/Config/Routes.php
```

### Problem: Error 404 Not Found
**Solusi:**
- Periksa Routes.php configuration
- Coba akses langsung `/login`
- Pastikan mod_rewrite aktif
- Cek .htaccess di folder public/

### Problem: Error Database Connection
**Solusi:**
```bash
# Pastikan MySQL running
net start mysql

# Cek database config
# Edit app/Config/Database.php jika perlu

# Buat database dan tabel
php setup-murid-data.php
```

### Problem: Session/Login Issues
**Solusi:**
- Pastikan writable/ folder memiliki permission write
- Clear session: hapus files di writable/session/
- Restart aplikasi

---

## 📁 File Structure

```
app-murid/
├── app/
│   ├── Controllers/
│   │   ├── Auth.php                 ✅ Login/logout controller
│   │   └── SafeSpaceController.php  ✅ Safe Space features
│   ├── Models/
│   │   └── SafeSpaceModel.php       ✅ Database operations
│   ├── Views/
│   │   ├── auth/
│   │   │   └── login.php            ✅ Login page
│   │   ├── dashboard/
│   │   │   └── index.php            ✅ Main dashboard
│   │   └── safe_space/
│   │       ├── dashboard.php        ✅ Safe space dashboard
│   │       ├── konsul_cepat.php     ✅ Quick counseling
│   │       ├── jadwal_konseling.php ✅ Counseling schedule
│   │       ├── jurnal_digital.php   ✅ Digital journal
│   │       └── pusat_informasi.php  ✅ Information center
│   └── Config/
│       ├── Routes.php               ✅ URL routing
│       ├── App.php                  ✅ App configuration
│       └── Database.php             ✅ DB configuration
├── public/                          ✅ Web root
├── writable/                        ✅ Cache & logs
├── testing-portal.html              ✅ Testing interface
├── debug-app-murid.php              ✅ Debug tool
├── run-app-murid.bat               ✅ Launch script
├── RUNNING_GUIDE.md                ✅ Running guide
├── SAFE_SPACE_COMPLETE.md          ✅ Safe Space docs
└── TESTING_GUIDE.md                ✅ Testing guide
```

---

## 🧪 Testing Portal

Akses `testing-portal.html` untuk:
- Quick launch aplikasi dengan berbagai port
- Testing semua fitur Safe Space
- Debug dan troubleshooting tools
- Sample credentials dan URL

---

## 📞 Support

Jika mengalami issues:
1. Cek `debug-app-murid.php` untuk diagnosis
2. Review log files di `writable/logs/`
3. Pastikan semua dependencies terinstall
4. Verifikasi database connection dan data

---

## ✅ Status Fitur

| Fitur | Status | Testing |
|-------|--------|---------|
| Auth System | ✅ Complete | ✅ Ready |
| Safe Space Dashboard | ✅ Complete | ✅ Ready |
| Konsul Cepat | ✅ Complete | ✅ Ready |
| Jadwal Konseling | ✅ Complete | ✅ Ready |
| Jurnal Digital | ✅ Complete | ✅ Ready |
| Pusat Informasi | ✅ Complete | ✅ Ready |
| API Endpoints | ✅ Complete | ✅ Ready |
| Database Setup | ✅ Complete | ✅ Ready |
| Documentation | ✅ Complete | ✅ Ready |

**🎉 Semua fitur aplikasi murid dengan Safe Space sudah lengkap dan siap untuk testing!**
