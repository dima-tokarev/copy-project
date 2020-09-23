<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCatOption extends Model
{
    public $table = "product_cat_options";

    protected $fillable = ['name'];

    public function typeOption()
    {
        return $this->hasMany('App\ProductTypeOption');
    }


    public function catBlock()
    {
        return $this->belongsToMany('App\Catalog','cat_block');
    }




}
