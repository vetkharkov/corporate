<?php

Route::get('/info', 'HomeController@index')->name('info');

Route::get('/test', function() {

//    dd(route('menus.edit','555'));
//    dd(route('article.index'));
//    /home/user/projects/corporate/public
//    return public_path();
//    return route('article.destroy', ['articlesb'=>'vet']);//http://127.0.0.1:8000/admin/article/vet
//dd(Gate::denies('EDIT_USERS'));
//dd(\Auth::user()->canDo('EDIT_MENU'));

});
//Route::get('/clear', function() {
//
//    return "Кэш очищен.";
//});

Route::get('/crypt', function() {

    return bcrypt('777');
});

Route::get('/user', function() {

    dd(Auth::user());
});

Route::resource('/', 'IndexController', [
    'only'=>['index'],//список методов в контроллере
    'names'=>[
        'index'=>'home'//имя роута(маршрута)
    ]
]);



//---------------------------------
Route::group([
    'prefix' => '/'
], function() {

    //Путь: /

    Route::resource('articles','ArticlesController', [
        'parameters' => [
            'articles' => 'alias'
        ]
    ]);

    Route::get('articles/cat/{cat_alias?}', [
        'uses' => 'ArticlesController@index',
        'as' => 'articlesCat'
    ]);//->where('cat_alias', '[/w-]+');// правила прописал в RouteServiceProvider

    Route::resource('portfolios', 'PortfolioController', [
        'parameters' => [
            'portfolios' => 'alias'
        ]
    ]);

});
//---------------------------------








Route::resource('comment', 'CommentController', ['only' => ['store']]);

Route::match(['get','post'], '/contacts',[
    'middleware' => 'auth',
    'uses' => 'ContactsController@index',
    'as' => 'contacts'
]);

// Формирование папки auth с набором макетов для регистрации, аутентификации и сброса пароля + Controllers
//php artisan make:auth

// Отображение формы аутентификации пользователя (добавление логина и пароля)
Route::get('login','Auth\LoginController@showLoginForm');

Route::post('login','Auth\LoginController@login');

//Выход из учетной записи
Route::get('logout','Auth\LoginController@logout');





//Админка
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth']
], function() {

    //Путь: /admin
    Route::get('/', ['uses' => 'Admin\IndexController@index', 'as' => 'adminIndex']);

    Route::resource('article', 'Admin\ArticlesController');

    Route::resource('permissions', 'Admin\PermissionsController');

    Route::resource('menus', 'Admin\MenusController');

    Route::resource('users', 'Admin\UsersController');


});



Auth::routes();