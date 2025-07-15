@echo off
echo ===============================================
echo SMART BOOKKEEPING - FOLDER-BASED URL SYSTEM
echo ===============================================
echo.
echo Struktur URL sesuai folder:
echo - /smartbk/app-guru/public
echo - /smartbk/app-ortu/public  
echo - /smartbk/app-superadmin/public
echo.
echo Sistem dinamis berdasarkan .env configuration
echo URL tetap sesuai struktur folder!
echo.
echo ===============================================
echo.

echo [1/3] Starting App-Guru Server (Port 8081)...
start "App-Guru Server" cmd /k "cd /d c:\xampp\htdocs\smartbk\app-guru && php spark serve --port=8081"
timeout /t 3 /nobreak >nul

echo [2/3] Starting App-Ortu Server (Port 8080)...
start "App-Ortu Server" cmd /k "cd /d c:\xampp\htdocs\smartbk\app-ortu && php spark serve --port=8080"
timeout /t 3 /nobreak >nul

echo [3/3] Opening Test Page...
start "" "http://localhost/smartbk/test-folder-urls.html"
timeout /t 2 /nobreak >nul

echo.
echo ===============================================
echo SERVERS STARTED!
echo ===============================================
echo.
echo Test URLs:
echo - http://localhost/smartbk/app-guru/public
echo - http://localhost/smartbk/app-ortu/public
echo.
echo Test Page: http://localhost/smartbk/test-folder-urls.html
echo.
echo Press any key to open main portal...
pause
start "" "http://localhost/smartbk"

echo.
echo ============================================
echo Starting all application servers...
echo ============================================
echo.

REM Start app-ortu on port 8080
echo [1/3] Starting app-ortu on port 8080...
cd /d "%~dp0app-ortu"
start cmd /k "title app-ortu (Port 8080) && echo Starting app-ortu server... && php spark serve --port=8080"

REM Wait a moment
timeout /t 2 /nobreak > nul

REM Start app-guru on port 8081
echo [2/3] Starting app-guru on port 8081...
cd /d "%~dp0app-guru"
start cmd /k "title app-guru (Port 8081) && echo Starting app-guru server... && php spark serve --port=8081"

REM Wait a moment
timeout /t 2 /nobreak > nul

REM Start app-superadmin on port 8082 (if exists)
if exist "%~dp0app-superadmin" (
    echo [3/3] Starting app-superadmin on port 8082...
    cd /d "%~dp0app-superadmin"
    start cmd /k "title app-superadmin (Port 8082) && echo Starting app-superadmin server... && php spark serve --port=8082"
) else (
    echo [3/3] app-superadmin folder not found, skipping...
)

REM Wait for servers to start
echo.
echo Waiting for servers to start completely...
timeout /t 5 /nobreak > nul

echo.
echo ============================================
echo     All Servers Started Successfully!
echo ============================================
echo.
echo Main Portal    : http://localhost/smartbk
echo Portal Guru    : http://localhost/smartbk/guru
echo Portal Ortu    : http://localhost/smartbk/ortu
echo Portal Admin   : http://localhost/smartbk/admin
echo.
echo Direct Access:
echo app-ortu      : http://localhost:8080
echo app-guru      : http://localhost:8081
echo app-superadmin: http://localhost:8082
echo.
echo ============================================
echo.

REM Start Apache if not running
echo [INFO] Checking Apache status...
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Apache is already running
) else (
    echo [INFO] Starting Apache...
    net start apache2.4 > nul 2>&1
    if %errorlevel% == 0 (
        echo [OK] Apache started successfully
    ) else (
        echo [WARNING] Could not start Apache automatically
        echo Please start XAMPP Control Panel and start Apache manually
    )
)

echo.
echo Press any key to open main portal in browser...
pause > nul

REM Open main portal in default browser
start http://localhost/smartbk

echo.
echo [INFO] Servers are running in background
echo [INFO] Close the individual terminal windows to stop servers
echo [INFO] Press any key to exit this window...
pause > nul
