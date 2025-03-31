<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = 
    [
        'user_id',
        'title', 
        'text'
    ];

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function files() : HasMany
    {
        return $this->hasMany(File::class);
    }

    public function likes() : HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
