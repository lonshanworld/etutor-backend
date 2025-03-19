<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
    public function files() : HasMany
    {
        return $this->hasMany(File::class);
    }
}
