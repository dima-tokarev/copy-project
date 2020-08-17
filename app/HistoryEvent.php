<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryEvent extends Model
{
    //

    public $table='history_event';

    protected $fillable = [

        'event_comment','history_id'
    ];


    public function eventHistory()
    {
        return  $this->belongsTo('App\History','history_id');
    }

}
