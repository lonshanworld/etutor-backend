<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'education_year'
    ];

    public function subjects() : BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }
}
