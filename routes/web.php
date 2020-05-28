<?php

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


// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
   	// Auth routes
	$router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refreshToken', 'AuthController@refreshToken');
    $router->get('profile', 'UserController@profile');

    $router->group(['prefix' => 'employer', 'middleware' => ['auth', 'employer']], function () use ($router) {
        // Employer user routes
        $router->get('users', 'UserController@users');
        $router->post('users', 'UserController@create');
        $router->get('users/{id}', 'UserController@show');
        $router->put('users/{id}', 'UserController@update');
        $router->delete('users/{id}', 'UserController@delete');
    });

    $router->group(['prefix' => 'admin', 'middleware'  => ['auth', 'admin']], function () use ($router) {
        $router->get('users', 'UserController@adminUsers');
        $router->post('users', 'UserController@adminCreate');
        $router->get('users/{id}', 'UserController@adminShow');
        $router->put('users/{id}', 'UserController@adminUpdate');
        $router->delete('users/{id}', 'UserController@delete');
    });
    
});