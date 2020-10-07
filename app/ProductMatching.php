<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMatching extends Model
{
    public $table = 'product_matching';

    protected $fillable = ['catalog_id','product_id','view_id'];
}
