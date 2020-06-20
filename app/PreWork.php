<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreWork extends Model
{
    //
    public $table = "preworks";




    public function author()
    {
       return  $this->belongsTo('App\User','author_id');
    }
}

