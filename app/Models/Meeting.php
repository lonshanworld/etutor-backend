<?php

namespace App\Models;

use App\Enums\MeetingType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'creator_id',
        'meeting_subject',
        'meeting_date',
        'meeting_time',
        'meeting_type',
        'location',
        'platform',
        'meeting_link'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meeting_type' => MeetingType::class
        ];
    }

    public function participants() : HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function records() : HasMany
    {
        return $this->hasMany(Record::class);
    }
}
