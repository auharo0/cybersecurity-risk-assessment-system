# Laravel Beginner Navigation Guide

> A simple guide for beginners to understand how to navigate a Laravel project, common commands, and database migrations.

---

# 1. Create a New Laravel Project

Using Composer:

```bash
composer create-project laravel/laravel my-project
```

Or using the Laravel Installer:

```bash
laravel new my-project
```

Enter the project folder:

```bash
cd my-project
```

---

# 2. Start the Development Server

```bash
php artisan serve
```

Default URL:

```
http://127.0.0.1:8000
```

---

# 3. Laravel Folder Structure

```
app/
    Models/
    Http/
        Controllers/

bootstrap/

config/

database/
    migrations/
    seeders/
    factories/

public/

resources/
    views/
    css/
    js/

routes/
    web.php
    api.php

storage/

tests/

vendor/
```

### Important Folders

| Folder               | Purpose                  |
| -------------------- | ------------------------ |
| app                  | Main application code    |
| app/Models           | Database models          |
| app/Http/Controllers | Controllers              |
| database/migrations  | Database structure       |
| database/seeders     | Sample data              |
| resources/views      | Blade templates          |
| routes/web.php       | Website routes           |
| routes/api.php       | API routes               |
| public               | Public files (index.php) |
| storage              | Logs and uploaded files  |

---

# 4. Common Artisan Commands

## Start Server

```bash
php artisan serve
```

---

## Show All Routes

```bash
php artisan route:list
```

---

## Clear Cache

```bash
php artisan optimize:clear
```

Or individually:

```bash
php artisan cache:clear

php artisan config:clear

php artisan route:clear

php artisan view:clear
```

---

## Generate Application Key

```bash
php artisan key:generate
```

Usually done once after installing Laravel.

---

# 5. Creating Files

## Create Controller

```bash
php artisan make:controller UserController
```

Resource controller:

```bash
php artisan make:controller UserController --resource
```

---

## Create Model

```bash
php artisan make:model User
```

Model + Migration:

```bash
php artisan make:model Product -m
```

Model + Migration + Controller:

```bash
php artisan make:model Product -mc
```

Everything:

```bash
php artisan make:model Product -a
```

`-a` creates:

- Model
- Migration
- Factory
- Seeder
- Controller
- Policy

---

## Create Migration

```bash
php artisan make:migration create_products_table
```

---

## Create Seeder

```bash
php artisan make:seeder ProductSeeder
```

---

## Create Factory

```bash
php artisan make:factory ProductFactory
```

---

## Create Middleware

```bash
php artisan make:middleware CheckAdmin
```

---

## Create Request Validation

```bash
php artisan make:request StoreProductRequest
```

---

# 6. Routes

Located at:

```
routes/web.php
```

Example:

```php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```

Controller route:

```php
Route::get('/products', [ProductController::class, 'index']);
```

Resource route:

```php
Route::resource('products', ProductController::class);
```

---

# 7. Controllers

Location:

```
app/Http/Controllers
```

Example:

```php
class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }
}
```

---

# 8. Models

Location:

```
app/Models
```

Example:

```php
class Product extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];
}
```

---

# 9. Views (Blade)

Location:

```
resources/views
```

Example:

```
resources/views/products/index.blade.php
```

Return it:

```php
return view('products.index');
```

---

# 10. Database Configuration

Open:

```
.env
```

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=
```

---

# 11. Migrations

Migration files are located in:

```
database/migrations
```

Example:

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->timestamps();
});
```

---

## Run Migrations

```bash
php artisan migrate
```

**Reminder:**

✅ Run this only after you've configured your database in the `.env` file.

✅ Once the migration has been successfully applied, **do not run `php artisan migrate` again unless you have created a new migration file.**

Laravel keeps track of executed migrations in the `migrations` table, so running the command again won't re-run existing migrations—it will only execute new pending migration files.

---

## Roll Back the Last Migration

```bash
php artisan migrate:rollback
```

Rollback multiple batches:

```bash
php artisan migrate:rollback --step=3
```

---

## Reset All Migrations

```bash
php artisan migrate:reset
```

---

## Refresh Migrations

Drops all tables and recreates them.

```bash
php artisan migrate:refresh
```

With seeders:

```bash
php artisan migrate:refresh --seed
```

---

## Fresh Migration

Deletes every table and rebuilds the database.

```bash
php artisan migrate:fresh
```

With seeders:

```bash
php artisan migrate:fresh --seed
```

⚠️ **Warning:** This permanently deletes all existing data.

---

# 12. Seeders

Run all seeders:

```bash
php artisan db:seed
```

Run a specific seeder:

```bash
php artisan db:seed --class=ProductSeeder
```

---

# 13. Model Relationships

One-to-Many:

```php
public function products()
{
    return $this->hasMany(Product::class);
}
```

Belongs-To:

```php
public function category()
{
    return $this->belongsTo(Category::class);
}
```

Many-to-Many:

```php
public function roles()
{
    return $this->belongsToMany(Role::class);
}
```

---

# 14. Useful Artisan Commands

List all Artisan commands:

```bash
php artisan list
```

Enter Laravel Tinker:

```bash
php artisan tinker
```

Display routes:

```bash
php artisan route:list
```

Check environment:

```bash
php artisan about
```

Optimize:

```bash
php artisan optimize
```

Clear everything:

```bash
php artisan optimize:clear
```

---

# 15. Basic Development Workflow

1. Create a project.
2. Configure the `.env` file.
3. Create the database.
4. Run migrations.
5. Create models.
6. Create controllers.
7. Define routes.
8. Build Blade views.
9. Test in the browser.
10. Add seeders and factories if needed.

---

# 16. Beginner Tips

- Always configure `.env` before running migrations.
- Use meaningful names for models, controllers, and migrations.
- Keep controllers focused on handling requests.
- Store database logic in models or dedicated service classes.
- Run `php artisan optimize:clear` if changes don't seem to take effect.
- Use `php artisan route:list` to verify your routes.
- Learn Eloquent ORM before writing raw SQL.
- Commit your work regularly using Git.

---

# 17. Most Common Commands (Quick Reference)

```bash
# Start development server
php artisan serve

# Create controller
php artisan make:controller ProductController

# Create model
php artisan make:model Product

# Create model + migration
php artisan make:model Product -m

# Create model + migration + controller
php artisan make:model Product -mc

# Create everything
php artisan make:model Product -a

# Create migration
php artisan make:migration create_products_table

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:reset

# Rebuild database
php artisan migrate:fresh

# Rebuild database with seeders
php artisan migrate:fresh --seed

# Run seeders
php artisan db:seed

# Show routes
php artisan route:list

# Clear caches
php artisan optimize:clear

# Generate app key
php artisan key:generate

# Open Tinker
php artisan tinker

# Show Laravel information
php artisan about
```

---

# Final Reminder About Migrations

✅ Configure your `.env` database settings first.

✅ Create your database manually (e.g., in MySQL).

✅ Run:

```bash
php artisan migrate
```

**Only once for your current set of migration files.**

You only need to run `php artisan migrate` again when:

- You create a **new migration**.
- You pull changes from another developer that include new migrations.

If you need to modify existing tables during development, create a **new migration** instead of editing a migration that has already been applied.

If you want to completely rebuild your database during development, use:

```bash
php artisan migrate:fresh
```

or

```bash
php artisan migrate:fresh --seed
```

⚠️ These commands erase all existing data before recreating the database.
