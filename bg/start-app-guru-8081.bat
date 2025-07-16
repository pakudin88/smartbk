@echo off
echo Starting App-Guru Server on Port 8081...
cd /d "c:\xampp\htdocs\smartbk\app-guru"
echo Current directory: %cd%
echo.
echo Starting php spark serve...
php spark serve --port=8081
