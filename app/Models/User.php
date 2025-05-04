<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\AccountStatus;
use App\Enums\GenderType;
use App\Http\Resources\Api\Staff\StaffResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'email',
        'password',
        'nationality',
        'gender',
        'address',
        'phone_number',
        'passport',
        'role_id',
        'passport',
        'status',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => GenderType::class,
            'status' => AccountStatus::class
        ];
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $name = $this->first_name;
        
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        
        if ($this->last_name) {
            $name .= ' ' . $this->last_name;
        }
        
        return $name;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function student() : HasOne
    {
        return $this->hasOne(Student::class);
    }
    public function tutor() : HasOne
    {
        return $this->hasOne(Tutor::class);
    }
    public function staff() : HasOne
    {
        return $this->hasOne(AuthorizedStaff::class);
    }
    public function notes() : HasMany
    {
        return $this->hasMany(Note::class);
    }
    public function blogs() : HasMany
    {
        return $this->hasMany(Blog::class);
    }
    
    public function activityLog()
    {
        return $this->hasOne(ActivityLog::class);
    }
}
