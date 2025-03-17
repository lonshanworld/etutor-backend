<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorizedStaff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'emergency_contact_name',
        'emergency_contact_phone',
        'start_date',
        'end_date'
    ];
}
