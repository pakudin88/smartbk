@echo off
echo ========================================
echo  MENJALANKAN SAFE SPACE BK - PORT 8080
echo ========================================
echo.

cd /d "c:\xampp\htdocs\simaklah-main\app-murid"

echo Memeriksa struktur file...
if exist "app\Controllers\Dashboard.php" (
    echo ✅ Dashboard Controller tersedia
) else (
    echo ❌ Dashboard Controller tidak ditemukan
    pause
    exit
)

if exist "app\Views\safe_space\konsul_cepat.php" (
    echo ✅ Konsul Cepat View tersedia
) else (
    echo ❌ Konsul Cepat View tidak ditemukan
    pause
    exit
)

echo.
echo Menjalankan server CodeIgniter...
echo URL Akses: http://localhost:8080
echo Konsul Cepat: http://localhost:8080/konsul-cepat
echo Dashboard: http://localhost:8080/dashboard
echo Login: http://localhost:8080/login
echo.
echo Login test account:
echo Username: siswa_test
echo Password: password123
echo.
echo Tekan Ctrl+C untuk stop server
echo ========================================
echo.

php spark serve --port=8080 --host=0.0.0.0
