<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function articles()
    {
//                 ???????????????? Article
        return $this->hasMany('Corp\Articles');
    }
}
