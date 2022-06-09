<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'auth'], function () use ($router){
	$router->get('/check-token', function () {
		return response()->json(b_json_response(true, 200, "Check token is expired?", ['valid' => auth()->check()]));
	});

	$router->group(['prefix' => 'post', 'middleware' => 'cors'], function () use ($router){
		$router->post('/logout', 'JwtAuthController@logout');
		$router->put('/password', 'JwtAuthController@password');
		$router->post('/me', 'JwtAuthController@me');
		$router->post('/refresh', 'JwtAuthController@refresh');
	});
	
	$router->group(['prefix' => 'post'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->get('/', 'PostController@index');
			$router->post('/create', 'PostController@store');
			$router->put('/update/{id}', 'PostController@update');
			$router->delete('/delete/{id}', 'PostController@destroy');
		});
	});

	$router->group(['prefix' => 'user'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->get('/', 'UsersController@index');
			$router->get('/employee', 'UsersController@employee');
			$router->get('/admin', 'UsersController@admin');
			$router->get('/detail/{id}', 'UsersController@show');
			$router->post('/create', 'UsersController@store');
			$router->put('/update/{id}', 'UsersController@update');
			$router->delete('/delete/{id}', 'UsersController@destroy');
		});
	});

	$router->group(['prefix' => 'dayoff'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->get('/', 'DayOffController@index');
			$router->get('/detail/{id}', 'DayOffController@show');
			$router->post('/create', 'DayOffController@store');
			$router->put('/update/{id}', 'DayOffController@update');
			$router->delete('/delete/{id}', 'DayOffController@destroy');
		});
	});

	$router->group(['prefix' => 'permittance'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->get('/', 'PermittanceController@index');
			$router->get('/user', 'PermittanceController@getByUser');
			$router->get('/detail/{id}', 'PermittanceController@show');
			$router->post('/create', 'PermittanceController@store');
			$router->put('/update/{id}', 'PermittanceController@update');
			$router->put('/approve/{id}', 'PermittanceController@approve');
			$router->delete('/delete/{id}', 'PermittanceController@destroy');
		});
	});

	$router->group(['prefix' => 'config'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->post('/create', 'ConfigurationController@store');
		});
	});

	$router->group(['prefix' => 'reward'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->get('/', 'RewardController@index');
			$router->post('/create', 'RewardController@store');
			$router->get('/detail/{id}', 'RewardController@show');
			$router->put('/update/{id}', 'RewardController@update');
			$router->delete('/delete/{id}', 'RewardController@destroy');
		});
	});

	$router->group(['prefix' => 'attendance'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->get('/', 'AttendanceController@index');
			$router->get('/status', 'AttendanceController@status');
			// $router->post('/create', 'AttendanceController@store');
			$router->get('/detail/{id}', 'AttendanceController@show');
			$router->put('/update/{id}', 'AttendanceController@update');
			$router->delete('/delete/{id}', 'AttendanceController@destroy');
		});
	});

	$router->group(['prefix' => 'report'], function () use ($router){
		$router->group(['middleware' => 'cors'], function () use ($router){
			$router->get('/', 'AttendanceController@index');
			$router->get('/status', 'AttendanceController@status');
			$router->post('/create', 'AttendanceController@store');
			$router->get('/detail/{id}', 'AttendanceController@show');
			$router->put('/update/{id}', 'AttendanceController@update');
			$router->delete('/delete/{id}', 'AttendanceController@destroy');
		});
	});
});

$router->group(['middleware' => 'cors'], function () use ($router){
	$router->post('/login', 'JwtAuthController@login');
	$router->post('/forgot', 'JwtAuthController@forgot');
	$router->post('/otp', 'JwtAuthController@otp');
	$router->post('/reset', 'JwtAuthController@reset');
});

$router->group(['prefix' => 'quotes'], function () use ($router){
	$router->get('/', 'QuotesController@index');
	$router->get('/detail/{id}', 'QuotesController@show');
	$router->post('/create', 'QuotesController@store');
	$router->put('/update/{id}', 'QuotesController@update');
	$router->delete('/delete/{id}', 'QuotesController@destroy');
});

$router->group(['prefix' => 'informations'], function () use ($router){
	$router->get('/', 'InformationController@index');
	$router->get('/detail/{id}', 'InformationController@show');
	$router->post('/create', 'InformationController@store');
	$router->put('/update/{id}', 'InformationController@update');
	$router->delete('/delete/{id}', 'InformationController@destroy');
	$router->get('/today', 'InformationController@today');
});

$router->group(['prefix' => 'download'], function () use ($router){
	$router->get('/example/{type}', 'AttendanceController@export');
});

$router->post('/attendance/create', 'AttendanceController@store');
$router->get('/user/all', 'UsersController@all');
