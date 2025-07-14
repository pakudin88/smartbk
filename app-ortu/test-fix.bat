@echo off
echo ========================================
echo  APP-ORTU ERROR "WHOOPS!" FIX TEST
echo ========================================
echo.

cd /d "c:\xampp\htdocs\smartbk\app-ortu"

echo 1. Testing PHP Basic...
php -v
echo.

echo 2. Testing Spark Command...
php spark list | head -5
echo.

echo 3. Starting Development Server...
echo Server will start on http://localhost:8080
echo Press Ctrl+C to stop the server
echo.
echo Open your browser to: http://localhost:8080
echo.

php spark serve --port=8080

pause
