@echo off
echo Starting App-Ortu Server on Port 8080...
cd /d "c:\xampp\htdocs\smartbk\app-ortu"
echo Current directory: %cd%
echo.
echo Starting php spark serve...
php spark serve --port=8080
