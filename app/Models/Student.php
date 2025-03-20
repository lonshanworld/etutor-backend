<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'major_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'emergency_contact_name',
        'emergency_contact_phone',
        'enrollment_date',
        'graduation_date',
        'current_year'
    ];

    public function studentTutoringSessions(): HasMany
    {
        return $this->hasMany(TutoringSession::class, 'student_id');
    }
}
