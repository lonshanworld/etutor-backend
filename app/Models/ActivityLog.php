<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'visit_count',
        'ip_address',
        'session_login',
        'session_logout'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
