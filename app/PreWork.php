<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreWork extends Model
{
    //
    public $table = "prework";

    protected $fillable = [
        'name', 'type_id','status_id','description','author_id','responsible_id'
    ];




    public function author()
    {
       return  $this->belongsTo('App\User','author_id');
    }

    public function attribute_object()
    {
        return  $this->hasOne('App\Custom_Type','object_type_id');
    }

    public function report()
    {
        return  $this->hasOne('App\PreworkReport','work_id');
    }

    public function commentsPreWork()
    {
        return $this->hasMany('App\Comments','object_id');
    }



}

