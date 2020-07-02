<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreworkReport extends Model
{
    //

    public $table = 'prework_report';

    protected $fillable = [
        'name', 'number','total_hours','total_minute','description','budget','work_id','author_id','start_time','end_time','type_id',
    ];

    public function author()
    {
        return  $this->belongsTo('App\User','author_id');
    }

    public function preWork()
    {
        return  $this->belongsTo('App\PreWork','work_id');
    }


    public function commentsPreWorkReport(){

        return $this->hasMany('App\Comments','object_id');
    }


}
