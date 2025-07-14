@echo off
echo ===============================================
echo     APP-ORTU LOGIN SERVER - READY TO START
echo ===============================================
echo.
echo Time: %date% %time%
echo.
echo Database: srv1412.hstgr.io/u809035070_simaklah
echo Login: Username/Password authentication
echo Design: Elegant, responsive, modern UI
echo.
echo ===============================================
echo.
echo Starting CodeIgniter development server...
echo Server URL: http://localhost:8080
echo.
echo Features ready:
echo   * Elegant login form
echo   * Username/password authentication  
echo   * Responsive design
echo   * Database integration
echo   * Session management
echo.
echo Press Ctrl+C to stop server
echo ===============================================
echo.

php spark serve --port=8080
