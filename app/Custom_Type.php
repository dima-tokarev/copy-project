<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custom_Type extends Model
{
    //
    public  $table ='custom_attribute_value';


    public function object()
    {
        return $this->belongsTo('App\PreWork','object_type_id');
    }



}
