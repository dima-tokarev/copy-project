<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute_Scheme_Type extends Model
{
    public $table = 'attribute_scheme_types';



    public function attr()
    {
        return $this->belongsTo('App\Attribute_Definition','attr_id');

    }
}
