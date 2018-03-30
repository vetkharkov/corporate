<?php

namespace Corp\Repositories;

use Corp\Article;

use Gate;

use Image;
use Config;

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

    public function addArticle($request)
    {

        if (Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');

        if (empty($data)) {
            return array('error' => 'Нет данных');
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

//        dd($data);

        if ($this->one($data['alias'], FALSE)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();
//            dd($request);
            return ['error' => 'Данный псевдоним уже используется'];
        }

//        dd($request);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
//dd($image);//UploadedFile Class
            if ($image->isValid()) {

//              $str - имя файла
                $str = str_random(8);
//  stdClass - Стандартный класс php
//  stdClass является порожденным пустым классом PHP, вроде как Object в Java или Object в Python
                $obj = new \stdClass;

                $obj->mini = $str . '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                $img = Image::make($image);

//                dd($img);
//  Формируем изображение размером 'path' => ['width'=>1024, 'height'=>768]
                $img->fit(
                    Config::get('settings.image')['width'],
                    Config::get('settings.image')['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/articles/' . $obj->path);
//  Формируем изображение размером 'max' => ['width'=>816, 'height'=>282]
                $img->fit(
                    Config::get('settings.articles_img')['max']['width'],
                    Config::get('settings.articles_img')['max']['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/articles/' . $obj->max);
//  Формируем изображение размером 'mini' => ['width'=>55, 'height'=>55]
                $img->fit(
                    Config::get('settings.articles_img')['mini']['width'],
                    Config::get('settings.articles_img')['mini']['height'])
                    ->save(public_path() . '/' . config('settings.theme') . '/images/articles/' . $obj->mini);


                $data['img'] = json_encode($obj);
//dd($data);
//                dump($this->model);
                $this->model->fill($data);
//                dd($this->model);
//                dd($request->user()->articles());
//
                if ($request->user()->articles()->save($this->model)) {
                    return ['status' => 'Материал добавлен'];
                }
            }
        }
    }

    public function updateArticle($request, $article) {

        if(Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token','image','_method');

        if(empty($data)) {
            return array('error' => 'Нет данных');
        }

        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        $result = $this->one($data['alias'],FALSE);

        if(isset($result->id) && ($result->id != $article->id)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Данный псевдоним уже успользуется'];
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()) {

                $str = str_random(8);

                $obj = new \stdClass;

                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);

                $img->fit(Config::get('settings.image')['width'],
                    Config::get('settings.image')['height'])->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path);

                $img->fit(Config::get('settings.articles_img')['max']['width'],
                    Config::get('settings.articles_img')['max']['height'])->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max);

                $img->fit(Config::get('settings.articles_img')['mini']['width'],
                    Config::get('settings.articles_img')['mini']['height'])->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini);

                $data['img'] = json_encode($obj);

            }

        }

        $article->fill($data);

        if($article->update()) {
            return ['status' => 'Материал обновлен'];
        }

    }

    public function deleteArticle($article) {

        if(Gate::denies('destroy', $article)) {
            abort(403);
        }

        $article->comments()->delete();

        if($article->delete()) {
            return ['status' => 'Материал удален'];
        }

    }

}

?>