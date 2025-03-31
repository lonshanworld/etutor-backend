<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'meeting_id',
        'user_id'
    ];
    
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
