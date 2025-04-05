<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrowserLog extends Model
{
    protected $fillable = [
        'log_id',
        'browser_id'
    ];
}
