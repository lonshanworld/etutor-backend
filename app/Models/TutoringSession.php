<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TutoringSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subject_id',
        'tutor_id',
        'student_id',
        'assigned_by',
        'deleted_by'
    ];
}
