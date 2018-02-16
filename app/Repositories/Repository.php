<?php

namespace Corp\Repositories;

use Config;

abstract class Repository
{

    protected $model = FALSE;//храним объект Corp\модели

    /*
    |--------------------------------------------------------------------------
    | Метод будет выбирать записи из таблицы
    |1 - параметр $select список полей которые выбираются из БД
    |2 - параметр $take сколько элементов нужно выбрать из таблицы
    |3 - параметр $pagination колличество элементов
    |    которые будут отображаться на странице
    |4 - параметр $where
    |--------------------------------------------------------------------------
    */
    public function get($select = '*', $take = FALSE, $pagination = FALSE, $where = FALSE)
    {

        $builder = $this->model->select($select);

        //$take - число выбираемых элементов из таблицы
        if ($take) {
            $builder->take($take);
        }
//$builder = DB::table('portfolios')->select('*')->take(5)->get();
//		dd($builder);

        if ($where) {
//            [0] - поле для которого формируется условие
//            [1] - значение условия
//            WHERE `category_id` = 2
            $builder->where($where[0], $where[1]);
        }

        if ($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());//У объекта Builder вызываем его метод get()
    }

    protected function check($result)
    {

        if ($result->isEmpty()) {
            return FALSE;
        }

        $result->transform(function ($item, $key) {

            if (is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->img = json_decode($item->img);
            }


            return $item;

        });

        return $result;

    }

//    Выборка одной записи
    public function one($alias, $attr = array())
    {
        $result = $this->model->where('alias', $alias)->first();

        return $result;
    }

}

?>