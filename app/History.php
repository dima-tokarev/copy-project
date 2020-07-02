<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    public $table='history';

    protected $fillable = [
        'event_comment','author_id','object_id','object_type_id','add_object_id'
    ];


}
