<?php

namespace Corp\Repositories;

use Config;

abstract class Repository
{

    protected $model = FALSE;//храним объект Corp\модели

    /*
    |--------------------------------------------------------------------------
    | Метод будет выбирать записи из таблицы
    |--------------------------------------------------------------------------
    */
    public function get($select = '*', $take = FALSE)
    {

        $builder = $this->model->select($select);

        //$take - число выбираемых элементов из таблицы
        if ($take) {
            $builder->take($take);
        }
//$builder = DB::table('portfolios')->select('*')->take(5)->get();
//		dd($builder);

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

}

?>