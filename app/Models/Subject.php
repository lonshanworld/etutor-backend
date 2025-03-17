<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'major_id'
    ];

    public function mojors() : BelongsToMany
    {
        return $this->belongsToMany(Major::class, 'major_subject');
    }
}
