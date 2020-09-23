<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTypeOption extends Model
{
    public $table = "product_type_options";

    protected $fillable = ['name','type','product_cat_option_id'];


    public function catType()
    {
        return $this->belongsTo('App\ProductCatOption','product_cat_option_id');
    }

    public function optionType()
    {
        return $this->hasMany('App\ProductOption','product_type_option_id');
    }


}
