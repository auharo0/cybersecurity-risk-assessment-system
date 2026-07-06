# PowerShell script to start Laravel server with PHP 8.3

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "  Laravel Development Server" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# Set PHP 8.3 path for this session
$env:Path = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;$env:Path"

Write-Host "Using PHP 8.3 from Laragon..." -ForegroundColor Green
php --version
Write-Host ""

Write-Host "Starting Laravel Development Server..." -ForegroundColor Yellow
Write-Host ""
Write-Host "Access your application at: http://127.0.0.1:8000" -ForegroundColor Green
Write-Host ""
Write-Host "Default admin credentials:" -ForegroundColor Cyan
Write-Host "  Email: admin@cras.com" -ForegroundColor White
Write-Host "  Password: password" -ForegroundColor White
Write-Host ""
Write-Host "Press CTRL+C to stop the server" -ForegroundColor Yellow
Write-Host ""

php artisan serve
