<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    //

    public $table = 'catalog';


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



    public function line()
    {
        return $this->hasMany('App\Product_line','catalog_cat_id');
    }


    public function blocks()
    {
        return $this->belongsToMany('App\ProductCatOption','cat_block');
    }

    public function saveBlock($inputBlock)
    {
        if(!empty($inputBlock)){
            $this->blocks()->sync($inputBlock);
        }else{
            $this->blocks()->detach();
        }
        return true;
    }





}
