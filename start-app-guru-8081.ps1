Write-Host "Starting App-Guru Server on Port 8081..." -ForegroundColor Green
Set-Location "c:\xampp\htdocs\smartbk\app-guru"
Write-Host "Current Directory: $(Get-Location)" -ForegroundColor Yellow
Write-Host "Starting PHP Spark Serve..." -ForegroundColor Yellow
php spark serve --port=8081
