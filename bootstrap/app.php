<?php

/* ==============================================================
| Author        : prabowoteguh
| Created at    : Fri, April 2 2021 23:49:20
| Modify at     : Fri, April 2 2021 23:49:20
| Location      : Unknown
| Description   : Konfigurasi Lumen
=================================================================*/

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Jakarta'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

$app->bind(\Illuminate\Contracts\Routing\UrlGenerator::class, function ($app) {
    return new \Laravel\Lumen\Routing\UrlGenerator($app);
});

/*
|--------------------------------------------------------------------------
| Load The Lumen Modules by "nwidart/laravel-modules"
|--------------------------------------------------------------------------
|
| Next we will include the Lumen Modules to grouping module by name
| Module is like a laravel package, it has some views, controllers or models.
| Laravel-modules uses 'path.public' which isn't defined by default in Lumen. 
| Register path.public before loading the service provider.
|
*/

$app->bind('path.public', function() {
    return __DIR__ . '/../public/';
});

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(Faker\Generator::class, function () {
    return Faker\Factory::create('id_ID');
});

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');
$app->configure('swagger-lume');
$app->configure('modules');
$app->configure('auth');
$app->configure('jwt');
$app->configure('service');
$app->configure('cors');
$app->configure('mail');
$app->configure('export');
$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    Fruitcake\Cors\HandleCors::class,
    App\Http\Middleware\CorsMiddleware::class,
]);


$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate  ::class,
    'cors' => App\Http\Middleware\CorsMiddleware::class,
    // 'client' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/
// $app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\CatchAllOptionsRequestsProvider::class);

$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(\SwaggerLume\ServiceProvider::class);
$app->register(\Nwidart\Modules\LumenModulesServiceProvider::class);
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
// $app->register(Laravel\Passport\PassportServiceProvider::class);
// $app->register(Dusterio\LumenPassport\PassportServiceProvider::class);
$app->register(Fruitcake\Cors\CorsServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Maatwebsite\Excel\ExcelServiceProvider::class);
$app->register(Barryvdh\DomPDF\ServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Registering Routes of Passport Auth
|--------------------------------------------------------------------------
|
| Next, you should call the LumenPassport::routes 
| method within the boot method of your application (one of your service providers).
| This method will register the routes necessary to issue access tokens
| and revoke access tokens, clients, and personal access tokens:
|
*/

// \Dusterio\LumenPassport\LumenPassport::routes($app->router, ['prefix' => 'v1/oauth']);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;