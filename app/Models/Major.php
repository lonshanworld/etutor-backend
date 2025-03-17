<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{

    protected $fillable = [
        'major_name',
        'education_year',
    ];

    public function subjects() : BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }
}
