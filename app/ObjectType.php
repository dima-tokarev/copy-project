<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectType extends Model
{
    public $table = "object_types";




    public function attr(){

        return $this->hasOne('App\Attribute_Definition','attr_type');

    }

}
