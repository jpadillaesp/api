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

$router->get('/', function () {
    return view('home', ['title' => 'Desarrollo de sistema de autogestión de conocimiento como herramienta informática inclusiva Open source que favorezca el aprendizaje de estudiantes con discapacidad auditiva leve de tercer nivel de educación superior']);
});

$router->get('api', function () use ($router) {
    return $router->app->version();
});
//$router->get('home', 'HomeController@index');

$router->group(['prefix' => 'api/v1'], function($router) {
    $router->get('/', function () {
        return '© 2018 UG-CISC 1.0.0';
    });

    $router->group(['prefix' => 'auth', 'middleware' => 'cors'], function () use ($router) {
        $router->post('login', 'AuthController@store');
        $router->get('logout', 'AuthController@destroy');
    });

    $router->group(['prefix' => 'users', 'middleware' => 'cors'], function () use ($router) {
        $router->post('add', 'UsersController@create');
        $router->get('view/{id:[0-9]+}', 'UsersController@show');
        $router->put('edit/{id:[0-9]+}', 'UsersController@edit');
        $router->delete('delete/{id:[0-9]+}', 'UsersController@destroy');
        $router->get('/', 'UsersController@index');
//        $router->get('/', ['as' => 'users_index_path', 'uses' => 'UsersController@index']);
//        $router->post('password/email', 'PasswordController@postEmail');
//        $router->post('password/reset/{token}', 'PasswordController@postReset');
        $router->get('rooms/{id:[0-9]+}', 'UsersController@OrchestratorRooms');
    });

    $router->group(['prefix' => 'orchestratorroom', 'middleware' => 'auth'], function () use ($router) {
        $router->post('add', 'OrchestratorRoomController@create');
        $router->get('view/{id:[0-9]+}', 'OrchestratorRoomController@view');
        $router->put('edit/{id:[0-9]+}', 'OrchestratorRoomController@update');
        $router->delete('delete/{id:[0-9]+}', 'OrchestratorRoomController@delete');
        $router->get('/', 'OrchestratorRoomController@index');
    });

    $router->group(['prefix' => 'trnascript', 'middleware' => 'auth'], function () use ($router) {
        $router->post('create', 'TranscriptController@create');
        $router->get('view/{id:[0-9]+}', 'TranscriptController@show');
        $router->put('edit/{id:[0-9]+}', 'TranscriptController@edit');
        $router->delete('delete/{id:[0-9]+}', 'TranscriptController@destroy');
        $router->get('/', 'TranscriptController@index');
    });

    $router->group(['prefix' => 'shared', 'middleware' => 'auth'], function () use ($router) {
        $router->post('create', 'SharedResourceController@store');
        $router->get('view/{id:[0-9]+}', 'SharedResourceController@show');
        $router->put('edit/{id:[0-9]+}', 'SharedResourceController@edit');
        $router->delete('delete/{id:[0-9]+}', 'SharedResourceController@destroy');
        $router->get('/', 'SharedResourceController@index');
        $router->get('{user_id:[0-9]+}/{id:[0-9]+}', 'SharedResourceController@show');
    });
});
