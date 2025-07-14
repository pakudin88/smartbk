@echo off
echo Starting App-Ortu Development Server...
cd /d "c:\xampp\htdocs\smartbk\app-ortu"
echo Current directory: %CD%
echo.
echo Testing basic configuration...
php test-app-basic.php
echo.
echo Starting server on port 8080...
echo Open your browser to: http://localhost:8080
echo.
echo Press Ctrl+C to stop the server
echo.
php spark serve --port=8080
pause
