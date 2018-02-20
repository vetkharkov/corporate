<?php

//Route::get('/clear', function() {
//
//    return "Кэш очищен.";
//});

Route::resource('/', 'IndexController', [
    'only'=>['index'],//список методов в контроллере
    'names'=>[
        'index'=>'home'//имя роута(маршрута)
    ]
]);

Route::resource('portfolios', 'PortfolioController', [
    'parameters'=>[
        'portfolios'=>'alias'
    ]
]);

Route::resource('articles','ArticlesController', [
    'parameters'=>[
        'articles'=>'alias'
    ]
]);

Route::get('articles/cat/{cat_alias?}', [
    'uses'=>'ArticlesController@index',
    'as'=>'articlesCat'
]);//->where('cat_alias', '[/w-]+');// правила прописал в RouteServiceProvider


Route::resource('comment', 'CommentController', ['only'=>['store']]);

Route::resource('comment', 'CommentController', ['only'=>['store']]);

Route::match(['get','post'], '/contacts',[
    'uses'=>'ContactsController@index',
    'as'=>'contacts'
]);
