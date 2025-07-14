@echo off
cd /d "c:\xampp\htdocs\simaklah-main\app-murid"
echo Starting CodeIgniter server on port 8080...
echo Access at: http://localhost:8080
php spark serve --port=8080 --host=0.0.0.0
