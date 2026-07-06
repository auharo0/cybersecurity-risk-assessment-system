# PowerShell script to update PATH to use PHP 8.3 from Laragon

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "  PHP 8.3 PATH Configuration Tool" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

$php83Path = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64"

# Check if PHP 8.3 exists
if (-not (Test-Path "$php83Path\php.exe")) {
    Write-Host "ERROR: PHP 8.3 not found at $php83Path" -ForegroundColor Red
    Write-Host "Please verify the PHP 8.3 installation path." -ForegroundColor Yellow
    pause
    exit 1
}

# Get current user PATH
$currentPath = [Environment]::GetEnvironmentVariable("Path", "User")

# Check if PHP 8.3 is already in PATH
if ($currentPath -like "*$php83Path*") {
    Write-Host "PHP 8.3 path is already in your PATH!" -ForegroundColor Green
} else {
    Write-Host "Adding PHP 8.3 to your PATH..." -ForegroundColor Yellow
    
    # Add PHP 8.3 to the beginning of PATH
    $newPath = "$php83Path;$currentPath"
    [Environment]::SetEnvironmentVariable("Path", $newPath, "User")
    
    Write-Host "PHP 8.3 has been added to your PATH!" -ForegroundColor Green
}

# Update PATH for current session
$env:Path = "$php83Path;$env:Path"

Write-Host ""
Write-Host "Verifying PHP version..." -ForegroundColor Yellow
& "$php83Path\php.exe" --version

Write-Host ""
Write-Host "=====================================" -ForegroundColor Green
Write-Host "  Configuration Complete!" -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""
Write-Host "IMPORTANT:" -ForegroundColor Yellow
Write-Host "1. Close this PowerShell window" -ForegroundColor White
Write-Host "2. Open a NEW PowerShell window" -ForegroundColor White
Write-Host "3. Navigate to your project folder" -ForegroundColor White
Write-Host "4. Run: php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "The PATH has been updated permanently." -ForegroundColor Green
Write-Host "New terminals will automatically use PHP 8.3!" -ForegroundColor Green
Write-Host ""

pause
