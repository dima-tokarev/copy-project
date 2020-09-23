<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    //
    public $table = 'matching_product_1c';

    protected $fillable = [
        'product_id','code_1c','is_base','product_1c_id'
    ];


    public function p_1c()
    {
        return $this->belongsTo('App\Product1c', 'product_1c_id');
    }

}
