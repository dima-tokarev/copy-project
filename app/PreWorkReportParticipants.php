<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreWorkReportParticipants extends Model
{
    //

    public $table = 'prework_report_participants';

    protected $fillable = [
        'name', 'contacts','position','is_agent','prework_id','created_at','updated_at'
    ];



}
