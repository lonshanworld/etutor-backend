<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    public function StudnetTutoringSessions(): HasOne
    {
        return $this->hasOne(TutoringSession::class, 'student_id', 'id');
    }
}
