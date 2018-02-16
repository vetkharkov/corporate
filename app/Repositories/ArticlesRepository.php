<?php

namespace Corp\Repositories;

use Corp\Article;

class ArticlesRepository extends Repository
{

    public function __construct(Article $articles)
    {
        $this->model = $articles;
    }

    public function one($alias, $attr = array())
    {
        $article = parent::one($alias, $attr);
//оптимизация
        if ($article && !empty($attr)) {
            $article->load('comments');//подгружаем модели комментарий для связаных моделей статей
            $article->comments->load('user');//подгружаем модели юзеров для связаных моделей комментариев
        }

        return $article;
    }

}

?>