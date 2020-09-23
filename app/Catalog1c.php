<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog1c extends Model
{
    //

    public $table = 'catalog_1c';


    protected $fillable = [
        'parent_id',
        'name',
        'url',
        'sort_order',
        'live',
        'type'
    ];

    public $timestamps = false;

    public function scopeIsLive($query)
    {
        return $query->where('live', true);
    }

    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }



/*    public function line()
    {
        return $this->hasMany('App\Product_line','catalog_cat_id');
    }*/



}
