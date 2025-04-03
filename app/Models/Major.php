<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
