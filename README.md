# E-commerce Laravel
> This is an E-commerce project created using Laravel React starter pack + sandbox Zarinpal integration which covers all the fundamentals to go for a scalable app.

App is 90% compelete. You may find some bugs in the code, issues are welcome. 

---
# Getting Started
## Installation
Please check the official Laravel installation guide before you start. [Official Documentation](https://laravel.com/)

Clone the repository
```
git clone https://github.com/alimaatin/e-commerce-laravel/
```
Switch to the repository folder
```
cd e-commerce-laravel
```
Install all the dependencies
```
composer install
npm install
```
Copy the example env file and make the required configuration changes in the .env file
```
cp .env.example .env
```
Generate a new application key
```
php artisan key:generate
```
Create storage link for file uploads
```
php artisan storage:link
```
Run the database migrations
```
php artisan migrate
```
Start the local development server
```
php artisan serve
```

**TL;DR command list**
```
git clone https://github.com/alimaatin/e-commerce-laravel/
cd e-commerce-laravel
composer install
npm install
cp .env.example .env
php artisan storage:link
php artisan key:generate
```

## Database Seeding
Seed products
```
php artisna db:seed
```
