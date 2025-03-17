<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{

    protected $fillable = [
        'major_name',
        'education_year',
    ];
}
