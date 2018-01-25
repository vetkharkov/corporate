<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Repositories\SlidersRepository;
use Corp\Repositories\PortfoliosRepository;

use Config;

class IndexController extends SiteController
{

    public function __construct(SlidersRepository $s_rep, PortfoliosRepository $p_rep)
    {

        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->s_rep = $s_rep;//слайдер
        $this->p_rep = $p_rep;//portfolio

        $this->bar = 'right';//правый сайтбар
        $this->template = env('THEME') . '.index';//pink.index (views/pink/index.blade.php)

    }

    public function index()
    {
        $portfolios = $this->getPortfolio();

        $content = view(env('THEME').'.content')->with('portfolios',$portfolios)->render();
        $this->vars = array_add($this->vars,'content', $content);



        $sliderItems = $this->getSliders();//коллекция моделей слайдера

        $sliders = view(env('THEME') . '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);
        return $this->renderOutput();//Вызов родительского метода рендера страницы
    }

    protected function getPortfolio() {

        $portfolio = $this->p_rep->get('*',Config::get('settings.home_port_count'));

        return $portfolio;

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
