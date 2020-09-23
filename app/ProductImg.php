<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    public $table = "product_img";

    protected $fillable = [

        'name', 'path','product_id'

    ];

}
