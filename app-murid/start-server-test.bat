@echo off
cd /d "c:\xampp\htdocs\simaklah-main\app-murid"
echo Starting CodeIgniter Development Server...
echo URL: http://localhost:8080
echo Press Ctrl+C to stop
php spark serve --host=127.0.0.1 --port=8080
pause
