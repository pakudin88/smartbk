@echo off
echo === STARTING APP-ORTU SERVER ===
echo Time: %date% %time%
echo.

echo Starting CodeIgniter development server...
echo Server will be available at: http://localhost:8080
echo.

echo Routes to test:
echo - http://localhost:8080/        (should redirect to login)
echo - http://localhost:8080/login   (should show login panel)
echo - http://localhost:8080/test    (should show basic message)
echo.

echo Press Ctrl+C to stop the server
echo.

cd /d "%~dp0"
php spark serve --port=8080
