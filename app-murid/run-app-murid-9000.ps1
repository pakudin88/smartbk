# SIMAKLAH - APP MURID (PORT 9000)
Write-Host "================================" -ForegroundColor Green
Write-Host "  SIMAKLAH - APP MURID (PORT 9000)" -ForegroundColor Green  
Write-Host "================================" -ForegroundColor Green
Write-Host ""
Write-Host "Starting app-murid on port 9000..." -ForegroundColor Yellow
Write-Host ""

Set-Location "c:\xampp\htdocs\simaklah-main\app-murid"
php spark serve --port=9000

Read-Host "Press Enter to exit"
