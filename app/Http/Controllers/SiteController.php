<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Repositories\MenusRepository;

use Menu;

class SiteController extends Controller
{
    protected $p_rep;//свойство для хранения класса объекта портфолио репозитория
    protected $s_rep;//свойство для хранения класса объекта слайдера репозитория
    protected $a_rep;//свойство для хранения класса объекта articles репозитория
    protected $m_rep;//свойство для хранения класса объекта меню репозитория
    protected $c_rep;//свойство для хранения объекта класса CommentsRepository

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template;//имя шаблона для хранения информации для отображения страницы

    protected $vars = array();//массив переменных передаваемых в шаблон

    protected $contentRightBar = FALSE;//свойстро хранения информации
    protected $contentLeftBar = FALSE;//контента сайтбара


    /*
    |--------------------------------------------------------------------------
    | информация о сайтбаре в классе 'sidebar-no' файла site.blade.php
    | no - нет сайтбара по умолчанию, переопределяется в дочерних классах
    | left - левый сайтбар
    | right - правый сайтбар
    |--------------------------------------------------------------------------
    */
    protected $bar = 'no';


    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    /*
    |--------------------------------------------------------------------------
    | Метод будет возвращать конкретный отработаный вид
    |--------------------------------------------------------------------------
    */
    protected function renderOutput()
    {
        $menu = $this->getMenu();
//        dd($menu);
        $navigation = view(env('THEME').'.navigation')->with('menu',$menu)->render();
//        dd($navigation);
//        Добавляем к переменным(vars) значение navigation
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if($this->contentRightBar) {
            $rightBar = view(env('THEME').'.rightBar')->with('content_rightBar',$this->contentRightBar)->render();
            $this->vars = array_add($this->vars,'rightBar', $rightBar);
        }

        if($this->contentLeftBar) {
            $leftBar = view(env('THEME').'.leftBar')->with('content_leftBar',$this->contentLeftBar)->render();
            $this->vars = array_add($this->vars,'leftBar',$leftBar);
        }

        $this->vars = array_add($this->vars, 'bar', $this->bar);

        $this->vars = array_add($this->vars, 'keywords', $this->keywords);
        $this->vars = array_add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars, 'title', $this->title);


        $footer = view(env('THEME').'.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function ($m) use ($menu) {

            foreach ($menu as $item) {

                if ($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }

        });

//        dump($mBuilder);

        return $mBuilder;
    }
}
