<?php

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/','IndexController',[
    'only'  => ['index'],//список методов в контроллере
    'names' => [
        'index'=>'home'//имя роута(маршрута)
    ]
]);
