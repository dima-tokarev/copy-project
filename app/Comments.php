<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //

    public $table ='comments';


    public $fillable = ['name','text','email','parent_id','object_id','object_type_id','author_id'];


    public function PreWorkComments()
    {
        return $this->belongsTo('App\PreWork','object_id');
    }

    public function user() {
        return $this->belongsTo('App\User','author_id');
    }

    public function PreWorkReportsComments()
    {
        return $this->belongsTo('App\PreworkReport','object_id');
    }
}
