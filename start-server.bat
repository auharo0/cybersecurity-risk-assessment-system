@echo off
echo Setting up PHP 8.3...
set PATH=C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;%PATH%

echo.
echo Starting Laravel Development Server...
echo.
echo Access your application at: http://127.0.0.1:8000
echo.
echo Default admin credentials:
echo   Email: admin@cras.com
echo   Password: password
echo.
echo Press CTRL+C to stop the server
echo.

php artisan serve
