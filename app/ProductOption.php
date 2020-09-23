<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    public $table = "product_options";

    protected $fillable = ['value_option','product_type_option_id'];
}
