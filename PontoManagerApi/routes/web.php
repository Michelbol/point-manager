<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'task', 'namespace' => 'Task'],function (Router $router){
    $router->post('token', 'LoginController@token');
});
$router->group(['middleware' => 'auth'], function(Router $router){
    $router->group(['prefix' => 'task', 'namespace' => 'Task'],function (Router $router) {
        $router->get('my-tasks', 'TaskController@myTasks');
//        $router->get('task/{id}', 'TaskController@findTask');
    });

    $router->group(['prefix' => 'note-time'], function(Router $router){
        $router->get('', 'NoteTimeController@list');
        $router->post('', 'NoteTimeController@save');
        $router->post('export', 'NoteTimeController@export');
        $router->put('{id}', 'NoteTimeController@update');
        $router->delete('many', 'NoteTimeController@deleteMany');
        $router->delete('{id}', 'NoteTimeController@delete');
    });
});
