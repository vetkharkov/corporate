<?php

namespace Corp\Repositories;

use Config;

abstract class Repository {
	
	protected $model = FALSE;//храним объект Corp\Menu

    /*
    |--------------------------------------------------------------------------
    | Метод будет выбирать все записи из таблицы
    |--------------------------------------------------------------------------
    */
	public function get() {
		
		$builder = $this->model->select('*');
		
//		dd($builder);
		
		return $builder->get();//У объекта Builder вызываем его метод get()
	}
	
}

?>