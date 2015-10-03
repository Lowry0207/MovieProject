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
/*
$app->get('/', function () use ($app) {
    return $app->welcome();
});*/


$app->get('/grafic','StatController@grafic');

$app->get('/','StatController@index');
$app->get('/company/detail/{id}','StatController@show');
$app->post('/jsonGrafic','StatController@jsonGrafic');


$app->get('/add/event','ApiController@addEvent');
$app->post('/add/event','ApiController@store');