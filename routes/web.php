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

$router->get('key', function(){
    return strtoupper(str_random(60));
});

$router->group(['prefix' => 'api'], function() use ($router){
    $router->group(['prefix' => 'users'], function() use ($router){
      $router->get('/', 'UsersController@index');
      $router->get('/show/{id}', 'UsersController@show');
      $router->post('add', 'UsersController@store');
      $router->put('update/{id}', 'UsersController@update');
      $router->delete('delete/{id}', 'UsersController@delete');
    });
});