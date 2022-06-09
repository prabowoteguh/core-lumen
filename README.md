<p align="center"><img src="https://tech.bodyfitstation.com/wp-content/uploads/2017/01/lumen-logo-1280x720.png" width="400"></p>
<p align="center">
<a href="https://travis-ci.org/laravel/lumen-framework"><img src="https://travis-ci.org/laravel/lumen-framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/lumen-framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# E-Absensi v-1.0

Aplikasi absensi berbasis web (e-absensi) online untuk memantau kinerja karyawan jarak jauh, dan pekerja work from home (WFH).

## Lumen PHP Framework

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Lumen Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Requirements
- Processor	: clock speed min 2,6 GHz
- RAM	: min 4 GB
- Storage	: min 2 GB
- Operation System	: Windows 7 or higher
- Browser	: Google Chrome, Firefox

### Platforms

- Linux
- CentOS
- Fedora
- windows Server

### HTTP Server

- Apache 2.4.35-VC15

### TECH STACK

- Composer 2.0
- PHP 7.3.22
- MySQL 5.7.24

### PHP Extension

- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension

### Library

- ```"darkaonline/swagger-lume": "8.*",```
- ```"laravel/lumen-framework": "^8.*",```
- ```"stoykov/lumen-modules": "0.1.2.x-dev",```
- ```"zircote/swagger-php": "3.*"```
- ```"flipbox/lumen-generator": "^8.2",```
- ```"fruitcake/laravel-cors": "^2.0",```
- ```"guzzlehttp/guzzle": "^7.2",```
- ```"illuminate/mail": "^8.37",```
- ```"tymon/jwt-auth": "^1.0"```


## Installation

- clone this repo
- go to this project `cd bacod-absensi-backend`
- run `cp .env.example .env` for your env configuration
- run `composer install`
- run `php artisan migrate --seed`
- Generate secret key `php artisan jwt:secret`
- execute sql file on db folder to your database

## Swagger Configuration

- Run ```php artisan swagger-lume:publish-config``` to publish configs (config/swagger-lume.php)
- Run ```php artisan swagger-lume:publish-views``` to publish views (resources/views/vendor/swagger-lume)
- Run ```php artisan swagger-lume:publish``` to publish everything
- Run ```php artisan swagger-lume:generate``` to generate docs

## Application Architecture

### Application 

This application using [HMVC Laravel Modules](https://nwidart.com/laravel-modules/v6/introduction). Table architecture using previx before name of table:
- Master: m_
- Transaction: t_
- History: h_
- Relations: r_

### Configs

- Application environment could be define inside `.env` file.
- Each environment have their corresponding folder inside `config` folder.

### Hooks

On Progress

### Layouts/Partials

- Core: `resources/views/{side}/core`
- Layouts: `resources/views/{side}/layouts`
- Partials: `resources/views/{side}/partials`
- Auth: `resources/views/{side}/auth`
- Custom error pages: `resources/views/{side}/errors`

### Frontend Assets

- CSS/SCSS: `public/css/*`
- Javascript: `public/js/*`
- Images: `public/img/*`
- Uploads: `public/uploads/*`
- Plugins: `public/plugins/*`
- Admin: `public/admin/*`

### Design 

- Check our design on figma [bacod-eabsensi](https://www.figma.com/file/CpQqVeKkCWefVeDIni3SzR/BACOD-Absensi-Finger-Print?node-id=0%3A1)
- Our repository of frontend [e-absensi](https://github.com/resitdc/bacod-absensi-frontend)

### API Testing

Postman API testing [prabowoteguh](https://www.getpostman.com/collections/e07e09538562268ae2d8)

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
