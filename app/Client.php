<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    public $table = 'client';

    protected $fillable = ['name','code1c','short_name'];

}
