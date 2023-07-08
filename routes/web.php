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

// Generate Application key | GET method
$router->get('/key', function ()  {
    return str_random(32);
});

// Example GET method
$router->get('/get', function ()  {
    return 'This GET Method';
});

//-----------------------------------
// Example Method Verb
//-----------------------------------
// Example POST method
$router->post('/post', function ()  {
    return 'This POST Method';
});

// Example PUT method
$router->post('/put', function ()  {
    return 'This PUT Method';
});

// Example PATCH method
$router->post('/PATCH', function ()  {
    return 'This PATCH Method';
});

// Example delete method
$router->post('/delete', function ()  {
    return 'This delete Method';
});

// Example delete method
$router->post('/options', function ()  {
    return 'This options Method';
});