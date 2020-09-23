<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_line extends Model
{
    //
    public $table = 'product_line';



    public function catalog_line()
    {
        return $this->belongsTo('App\Catalog', 'catalog_cat_id');
    }
}
