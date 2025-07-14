#!/bin/bash

# Script untuk menjalankan aplikasi murid dengan berbagai port
# Pastikan Anda berada di direktori app-murid

echo "=== PANDUAN MENJALANKAN APLIKASI MURID ==="
echo ""
echo "1. Buka terminal/command prompt"
echo "2. Navigasi ke folder app-murid:"
echo "   cd c:/xampp/htdocs/simaklah-main/app-murid"
echo ""
echo "3. Jalankan dengan salah satu perintah berikut:"
echo ""

# Default port (8080)
echo "A. Port 8080 (Default):"
echo "   php spark serve"
echo "   Akses: http://localhost:8080"
echo ""

# Custom port 9000
echo "B. Port 9000:"
echo "   php spark serve --port=9000"
echo "   Akses: http://localhost:9000"
echo ""

# Custom port 8082 (sesuai konfigurasi)
echo "C. Port 8082 (Sesuai Konfigurasi App.php):"
echo "   php spark serve --port=8082"
echo "   Akses: http://localhost:8082"
echo ""

# Custom port 3000
echo "D. Port 3000:"
echo "   php spark serve --port=3000"
echo "   Akses: http://localhost:3000"
echo ""

# Custom host dan port
echo "E. Custom Host dan Port:"
echo "   php spark serve --host=0.0.0.0 --port=9000"
echo "   Akses: http://localhost:9000 atau http://IP_ADDRESS:9000"
echo ""

echo "=== AKUN TESTING MURID ==="
echo ""
echo "Username: ahmad.budi    | Password: 123456"
echo "Username: siti.aisyah   | Password: 123456"
echo "Username: rudi.santoso  | Password: 123456"
echo "Username: maya.sari     | Password: 123456"
echo "Username: doni.pratama  | Password: 123456"
echo ""

echo "=== TROUBLESHOOTING ==="
echo ""
echo "Jika muncul halaman CodeIgniter Welcome:"
echo "1. Pastikan Anda menjalankan dari folder app-murid"
echo "2. Cek apakah file Routes.php sudah benar"
echo "3. Pastikan Auth controller dan view login ada"
echo "4. Coba clear cache: php spark cache:clear"
echo ""

echo "Jika error database:"
echo "1. Pastikan XAMPP MySQL sudah running"
echo "2. Cek konfigurasi database di app/Config/Database.php"
echo "3. Pastikan tabel murid sudah ada dan berisi data"
echo ""

echo "=== FITUR YANG TERSEDIA ==="
echo ""
echo "Setelah login berhasil, Anda dapat mengakses:"
echo "- Dashboard Murid: /dashboard"
echo "- Safe Space Dashboard: /safe-space/dashboard"
echo "- Konsul Cepat: /safe-space/konsul-cepat"
echo "- Jadwal Konseling: /safe-space/jadwal-konseling"
echo "- Jurnal Digital: /safe-space/jurnal-digital"
echo "- Pusat Informasi: /safe-space/pusat-informasi"
echo ""
