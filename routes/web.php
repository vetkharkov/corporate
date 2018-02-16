<?php

//Route::get('/clear', function() {
//
//    return "Кэш очищен.";
//});

Route::resource('/', 'IndexController', [
    'only' => ['index'],//список методов в контроллере
    'names' => [
        'index' => 'home'//имя роута(маршрута)
    ]
]);

Route::resource('portfolios', 'PortfolioController', [

    'parameters' => [

        'portfolios' => 'alias'

    ]

]);

Route::resource('articles','ArticlesController',[

    'parametres'=>[

        'articles' => 'alias'

    ]

]);

Route::get('articles/cat/{cat_alias?}',['uses'=>'ArticlesController@index','as'=>'articlesCat']);


Route::resource('comment','CommentController',['only'=>['store']]);

Route::resource('comment','CommentController',['only'=>['store']]);
