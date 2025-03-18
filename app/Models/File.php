<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'post_id',
        'message_id',
        'note_id',
        'url_link'
    ];
}
