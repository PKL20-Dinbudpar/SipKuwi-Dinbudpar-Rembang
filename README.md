## How to Install

#### Preset Laravel Excel
```
pastikan uncomment `extension=gd` pada `php.ini` server xampp
```

#### 1. Install composer dependencies
```
composer install
```

#### 2. Copy .env.example or rename the .env.example file to .env
```
cp .env.example .env
```
Edit the configuration inside .env, for example:
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=koperasi_kejujuran

In the example above we create database named koperasi_kejujuran which runs on Localhost (127.0.0.1) on port 3306

#### 3. Generate key
```
php artisan key:generate
```

#### 4. Run the migration
```
php artisan migrate --seed
```

#### 5. Connect storage
```
php artisan storage:link
```

#### 6. Run the server
```
php artisan serve
```

### Credit Theme: 
Soft UI Dashboard Laravel Livewire by Creative Tim & UPDIVISION
* Download      : [www.creative-tim.com](https://www.creative-tim.com/product/soft-ui-dashboard-laravel-livewire)
* Documentation : https://soft-ui-dashboard-laravel-livewire.creative-tim.com/documentation/bootstrap/overview/soft-ui-dashboard/index.html
