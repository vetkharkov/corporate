<?php

namespace Corp\Http\Controllers\Auth;

use Corp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $loginView;

    /**
     * Редирект после успешной аутентификации.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $loginView = pink.login
        $this->loginView = config('settings.theme').'.login';
    }

    /**
     * Поле по которому аутентифицируется пользователь.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    public function showLoginForm()
    {
//        Проверка на существования свойства $loginView и $view = $loginView
        $view = property_exists($this, 'loginView') ? $this->loginView : '';
//        Проверка на наличие вида с именем которое записано в $view
        if (view()->exists($view)) {
            return view($view)->with('title', 'Вход на сайт');
        }
// Если нет этого вида, то ошибка 404
        abort(404);
    }



}
