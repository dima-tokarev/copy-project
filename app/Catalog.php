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
        'type',
<<<<<<< HEAD
        'hasContent',
=======
        'hasСontent',
>>>>>>> 3d9391b20c20d20076df558e8ce3a7470262c232
        'view_id'
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
        return $this->belongsToMany('App\ProductCatOption','cat_block')->withPivot('sort')->orderBy('sort');
    }


    public function products()
    {
        return $this->belongsToMany('App\Product','product_matching')->withPivot('view_id')->orderBy('view_id');
    }

    public function saveBlock($inputBlock,$sort)
    {

        if(!empty($inputBlock) && !empty($sort)){
            $data = [];

            foreach ($inputBlock as $index => $val){

                $data[$val] = ['sort' => $sort[$index]];

            }

            $this->blocks()->sync($data);


        }else{
            $this->blocks()->detach();
        }
        return true;
    }





}
