<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute_Definition extends Model
{
    //
    public $table = 'attribute_definitions';



    public function attrType()
    {
      $this->hasOne('App\Attribute_Scheme_Type','attr_id');
    }


}
