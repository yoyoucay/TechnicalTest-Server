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

# Integrasi Route Dengan Controller
$router->get('key', 'ExampleController@GenerateKey');

# Routes for Authentication
$router->post('/register','AuthController@Register');
$router->post('/login','AuthController@Login');

# Routes for User 
$router->post('/user/upload','UserController@UploadImage');
$router->post('/user/{id}','UserController@Show');

# Routes for Room 
$router->get('/room/list','RoomController@ShowAll');
$router->post('/room/detail/{id}','RoomController@ShowDetail');
$router->post('/room/create','RoomController@Create');
$router->post('/room/update','RoomController@Update');
$router->post('/room/remove/','RoomController@Remove');



# Routes Practices
// $router->post('post', 'ExampleController@PostExample');
// $router->get('room/{id}', 'ExampleController@GetRoomID');
// $router->get('room/{id}/{category}', 'ExampleController@GetRoomCat');
// $router->get('foobar', 'ExampleController@fooBar');
// $router->post('foobars', 'ExampleController@fooBar');
// $router->post('user/profile','ExampleController@GetUser');

// $router->get('category/{class}', function($class){
//     return 'Class Room : '.$class;
// });

// 

# Routes tanpa Optional Parameter
// $router->get('room/{category}/{room_number}', function($category, $room_number){
//     return 'Category Room : '.$category.' Room Number : '.$room_number;
// });

# Routes Memakai Optional Parameter
// $router->get('room/{category}[/{room_number}]', function($category, $room_number = null){
//     if($room_number == null) {
//         return 'Category Room : '.$category;
//     }else{
//         return 'Category Room : '.$category.' | Room Number : '.$room_number;
//     }
// });

# Memberikan alias pada route
// $router->get('routes',['as' => 'route.profile', function(){
//     return route('route.profile');
// }]);

# Routes menggunakan Redirect
// $router->get('route', function(){
//     return redirect()->route('route.profile');
// });

# Routes menggunakan Grouping
// $router->group(['prefix' => 'user', 'middleware' => 'verify'], function() use ($router){
//     $router->get('profile', function(){
//         return 'User profile';
//     });

//     $router->get('settings', function(){
//         return 'Settings profile';
//     });

//     $router->get('verify[/{key_verif}]', function($key_verif = null){
//         return 'Key verify User : '. $key_verif;
//     });
// });

# Routes untuk user jika akunnya belum melakukan verifikasi  
// $router->get('/verify', function ()  {
//     return 'Yeet! anda belum melakukan verifikasi';
// });
 


#-----------------------------------
# Example Method Verb
#-----------------------------------
# Example GET method
// $router->get('get', function ()  {
//     return 'This GET Method';
// });

# Example POST method
// $router->post('post', function ()  {
//     return 'This POST Method';
// });

# Example PUT method
// $router->post('put', function ()  {
//     return 'This PUT Method';
// });

# Example PATCH method
// $router->post('patch', function ()  {
//     return 'This PATCH Method';
// });

# Example delete method
// $router->post('delete', function ()  {
//     return 'This delete Method';
// });

# Example delete method
// $router->post('options', function ()  {
//     return 'This options Method';
// });