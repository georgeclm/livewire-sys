<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Simple Chat App SPA

This application use Laravel for the framework, bootstrap and pure blade for frontend, Livewire, and Turbolinks for the SPA system. This app you can chat with other user, check unread messages, last chat with other user just like Whatsapp.Simple App

![alt text](https://github.com/georgeclm/livewire-sys/blob/main/public/images/chat-app.png?raw=true)


## To use the template

1. **Clone the Repository**
```bash
git clone https://github.com/georgeclm/cashier-app.git
cd cashier-app
composer install
npm install
copy .env.example .env
```

2. **Open ```.env``` and then set the database as your system configuration**
```
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. **Install The Website and the database**
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

4. **Run the website**
```bash
php artisan serve
```
4. **Run the website**
### Visit 127.0.0.1

