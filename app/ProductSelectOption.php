<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSelectOption extends Model
{
    public $table = "product_select_options";

    protected $fillable = [

        'product_cat_id', 'product_id','type_option_value','value_option'

    ];



}
