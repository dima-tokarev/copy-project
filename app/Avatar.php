<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    //

    public $table='avatars';

    protected $fillable = [
        'path', 'filename','user_id'
    ];


    public function userAvatar(){
        return $this->belongsTo('App\User','user_id');
    }


}
