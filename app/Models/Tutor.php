<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'subject_id',
        'created_by',
        'deleted_by',
        'updated_by',
        'qualifications',
        'experience'
    ];
}
