<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Repositories\SlidersRepository;

use Config;

class IndexController extends SiteController
{

    public function __construct(SlidersRepository $s_rep)
    {

        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->s_rep = $s_rep;//слайдер

        $this->bar = 'right';//правый сайтбар
        $this->template = env('THEME') . '.index';//pink.index (views/pink/index.blade.php)

    }

    public function index()
    {
        $sliderItems = $this->getSliders();//коллекция моделей слайдера

        $sliders = view(env('THEME') . '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);
        return $this->renderOutput();//Вызов родительского метода рендера страницы
    }

    public function getSliders()
    {
        $sliders = $this->s_rep->get();//Collection slider

        if ($sliders->isEmpty()) {
            return FALSE;
        }

        $sliders->transform(function ($item, $key) {

            $item->img = Config::get('settings.slider_path') . '/' . $item->img;
            return $item;

        });


        return $sliders;
    }

}
