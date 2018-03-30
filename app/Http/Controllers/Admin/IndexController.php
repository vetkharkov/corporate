<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Controllers\Controller;

use Auth;
use Gate;

class IndexController extends AdminController
{

    public function __construct()
    {

        parent::__construct();
//        $this->middleware('auth');
//
//        if (!$this->user) {
//            abort(403);
//        }

//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }

        $this->template = config('settings.theme') . '.admin.index';

    }

    public function index()
    {
        //Объект пользователя
        $this->user = Auth::user();
        $this->title = 'Панель администратора';

//        dd($this->user);

        if(Gate::denies('VIEW_ADMIN')) {
            abort(403);
        }

        return $this->renderOutput();

    }
}
