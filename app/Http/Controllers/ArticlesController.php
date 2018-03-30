<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Repositories\PortfoliosRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CommentsRepository;

use Corp\Category;

class ArticlesController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep)
    {

        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->p_rep = $p_rep;//portfolio объект класса PortfoliosRepository
        $this->a_rep = $a_rep;//articles статьи
        $this->c_rep = $c_rep;//объект класса CommentsRepository

        $this->bar = 'right';//правый сайтбар

        $this->template = config('settings.theme') . '.articles';//имя шаблона : pink.articles (views/pink/articles.blade.php)

    }

//render() - преобразует объект вида в строку

    public function index($cat_alias = false)
    {

        $this->title = 'Блог';
        $this->keywords = 'Ключи на странице блога';
        $this->meta_desc = 'Краткое описание страници блога';

        $articles = $this->getArticles($cat_alias);

        $content = view(config('settings.theme') . '.articles_content')->with('articles', $articles)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));


        $this->contentRightBar = view(config('settings.theme') . '.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios]);


        return $this->renderOutput();
    }

    public function getComments($take)
    {

        $comments = $this->c_rep->get(['text', 'name', 'email', 'site', 'article_id', 'user_id'], $take);

        //        Для оптимизации SQL запросови
        if ($comments) {
            $comments->load('user','article');
        }

        return $comments;
    }

    public function getPortfolios($take)
    {
        $portfolios = $this->p_rep->get([
            'title',
            'text',
            'alias',
            'customer',
            'img',
            'filter_alias'
        ],
            $take);
        return $portfolios;
    }

    public function getArticles($alias = FALSE)
    {
        $where = FALSE;

        if($alias) {
//            Получаем id категории
            // WHERE `alias` = $alias
            $id = Category::select('id')->where('alias',$alias)->first()->id;
//            dd($id);
            //WHERE `category_id` = $id
            $where = ['category_id',$id];
        }

        $articles = $this->a_rep->get([
            'id',
            'title',
            'alias',
            'created_at',
            'img', 'desc',
            'user_id',
            'category_id',
            'keywords',
            'meta_desc'
        ],
            FALSE,
            TRUE,
            $where);

//        Для оптимизации SQL запросов
        if ($articles) {
            $articles->load('user','category','comments');
        }

        return $articles;

    }

    public function show($alias = FALSE) {

//        $alias - псевдоним статьи
        $article = $this->a_rep->one($alias,['comments' => TRUE]);


        if($article) {
            $article->img = json_decode($article->img);
        }

//        dd($article->comments->groupBy('parent_id'));

        if(isset($article->id)) {
            $this->title = $article->title;
            $this->keywords = $article->keywords;
            $this->meta_desc = $article->meta_desc;
        }

        $content = view(config('settings.theme').'.article_content')->with('article',$article)->render();
        $this->vars = array_add($this->vars,'content',$content);


        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));


        $this->contentRightBar = view(config('settings.theme').'.articlesBar')->with(['comments' => $comments,'portfolios' => $portfolios]);


        return $this->renderOutput();
    }


}
