@echo off
echo ====================================
echo   SIMAKLAH APP-MURID SERVER
echo ====================================
echo.

cd /d "c:\xampp\htdocs\simaklah-main\app-murid"

echo Checking environment...
if not exist ".env" (
    echo ERROR: .env file missing!
    pause
    exit /b 1
)

if not exist "vendor\autoload.php" (
    echo Installing dependencies...
    composer install
)

echo.
echo Starting server on port 8080...
echo URL: http://localhost:8080
echo.
echo Login credentials:
echo Username: ahmad.budi
echo Password: 123456
echo.
echo Press Ctrl+C to stop server
echo.

php spark serve --port=8080 --host=localhost
