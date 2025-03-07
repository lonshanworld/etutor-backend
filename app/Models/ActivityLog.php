<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'entity_id',
        'web_page_id',
        'web_browser_id',
        'visit_count',
        'ip_address',
        'user_agents'
    ];
}
