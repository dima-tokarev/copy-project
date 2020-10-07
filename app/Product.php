<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public $table = "product";

    protected $fillable = [
        'name', 'series_id','view_id'
    ];


    public function productImg(){

        return $this->hasMany('App\ProductImg');
    }

    public function category(){

        return $this->belongsTo('App\Catalog','series_id');
    }


    public function categoryMatching()
    {
        return $this->belongsToMany('App\Catalog','product_matching')->withPivot('view_id')->orderBy('view_id');
    }



}
