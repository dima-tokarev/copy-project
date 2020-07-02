<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    public $table = 'attachment';

    protected $fillable = [
        'path', 'filename','size'
    ];

    public function link_attachment()
    {
        return $this->hasOne('App\Attachment_link','attachment_id');
    }
}
