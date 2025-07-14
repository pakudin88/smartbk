@echo off
echo ================================
echo   SIMAKLAH - APP MURID (PORT 9000)
echo ================================
echo.
echo Starting app-murid on port 9000...
echo.

cd /d "c:\xampp\htdocs\simaklah-main\app-murid"
php spark serve --port=9000

pause
