# Cybersecurity Risk Assessment System - Setup Complete! ✅

## Quick Start

### Option 1: Using the Start Script (Easiest)
Double-click `start-server.bat` or run:
```bash
start-server.bat
```

### Option 2: Manual Start
If the batch file doesn't work, open PowerShell and run:
```powershell
$env:Path = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;$env:Path"
php artisan serve
```

## Access the Application

- **URL:** http://127.0.0.1:8000
- **Admin Email:** admin@cras.com
- **Admin Password:** password

## Database Configuration

The application is configured to run with SQLite (file-based database) instead of MySQL:
- **Database File:** `database/database.sqlite`
- **No MySQL/MariaDB required!**

## Important Notes

### PHP Version Issue
Your system has multiple PHP versions:
- **PHP 8.2.12** (XAMPP - old, can't run this project)
- **PHP 8.3.30** (Laragon - currently being used ✅)

**Every time you open a new terminal**, you need to run this command first:
```powershell
$env:Path = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;$env:Path"
```

### Making PHP 8.3 Permanent (Optional)
To avoid running the command every time:
1. Press `Win + R`, type `sysdm.cpl`, press Enter
2. Go to **Advanced** tab → **Environment Variables**
3. Under **System variables**, find **Path**
4. Click **Edit**
5. Move `C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64` to the **top** of the list
6. Click **OK** on all windows
7. Restart your terminal

## Available Commands

### Start Development Server
```bash
php artisan serve
```

### Run Migrations (Create Tables)
```bash
php artisan migrate
```

### Seed Database (Add Sample Data)
```bash
php artisan db:seed
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Build Frontend Assets
```bash
npm run build
```

### Watch Frontend Assets (for development)
```bash
npm run dev
```

## Troubleshooting

### "Your PHP version does not satisfy requirement"
You're using PHP 8.2. Run this first:
```powershell
$env:Path = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;$env:Path"
```

### "SQLSTATE[HY000]: General error: 1 no such table"
Run migrations:
```bash
php artisan migrate --force
```

### Frontend Not Loading
Build the assets:
```bash
npm run build
```

## Project Structure

- `app/` - Application logic (Controllers, Models)
- `database/` - Migrations, Seeders, SQLite database
- `resources/views/` - Blade templates
- `routes/` - Web routes
- `public/` - Public assets

## Need Help?

Check the Laravel documentation: https://laravel.com/docs
