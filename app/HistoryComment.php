<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryComment extends Model
{
    //

    public $table='history_comment';

    protected $fillable = [

        'author','comment','history_id'

    ];

    public function commentHistory()
    {
        return  $this->belongsTo('App\History','history_id');
    }


}
