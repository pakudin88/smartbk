@echo off
echo ========================================
echo  SIMAKLAH - Safe Space Server Test
echo ========================================
echo.

cd /d "c:\xampp\htdocs\simaklah-main\app-murid"

echo Clearing cache...
php spark cache:clear

echo.
echo Dumping autoload...
composer dump-autoload

echo.
echo ========================================
echo  Testing XAMPP Apache (Port 80)
echo ========================================
echo URL untuk test XAMPP:
echo - Dashboard: http://localhost/simaklah-main/app-murid/public/dashboard
echo - Konsul Cepat: http://localhost/simaklah-main/app-murid/public/safe-space/konsul-cepat
echo - Test Simple: http://localhost/simaklah-main/app-murid/public/test-simple
echo.

echo ========================================
echo  Starting CodeIgniter Development Server
echo ========================================
echo URL untuk test Spark Serve:
echo - Dashboard: http://localhost:8080/dashboard
echo - Konsul Cepat: http://localhost:8080/safe-space/konsul-cepat
echo - Test Simple: http://localhost:8080/test-simple
echo.
echo Server will start in 3 seconds...
echo Press Ctrl+C to stop server
echo ========================================
timeout /t 3

php spark serve --host=127.0.0.1 --port=8080
