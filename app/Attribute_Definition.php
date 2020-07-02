<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute_Definition extends Model
{
    //
    public $table = 'attribute_definitions';



    public function attrType()
    {
       return $this->belongsTo('App\ObjectType','attr_type');
    }


}
