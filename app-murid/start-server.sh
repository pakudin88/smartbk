#!/bin/bash
echo "Starting CodeIgniter Server on Port 8080..."
echo "Access URLs:"
echo "- Dashboard: http://localhost:8080/dashboard" 
echo "- Konsul Cepat: http://localhost:8080/konsul-cepat"
echo "- Login: http://localhost:8080/login"
echo ""
echo "Login credentials:"
echo "Username: siswa_test"
echo "Password: password123"
echo ""
echo "Press Ctrl+C to stop the server"
echo "=================================="

cd "c:\xampp\htdocs\simaklah-main\app-murid"
php spark serve --port=8080 --host=0.0.0.0
