<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment_link extends Model
{
    //
    public $table = 'attachment_link';

    protected $fillable = [
        'attachment_id', 'object_id','object_type_id'
    ];

    public function attachment()
    {
        return $this->belongsTo('App\Attachment','attachment_id');
    }



}
