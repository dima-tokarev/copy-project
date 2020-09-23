<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatBlock extends Model
{
    //
    public $table = 'cat_block';

    protected $fillable = ['catalog_id','product_cat_option_id'];
}
