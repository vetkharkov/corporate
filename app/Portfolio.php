<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    //one to many
    //one filters -> many portfolios
    public function filter() {
        return $this->belongsTo('Corp\Filter','filter_alias','alias');
    }
}
