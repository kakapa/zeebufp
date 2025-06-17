<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime',
            'profiled_at' =>  'datetime',
            'password' => 'hashed',
            'gender' => \App\Enums\GenderEnums::class,
            'work_status' => \App\Enums\WorkStatusEnums::class,
            'educational_level' => \App\Enums\EducationLevelEnums::class,
            'status' => \App\Enums\UserStatusEnums::class
        ];
    }

    /**
     * Get User's name for dashboard
     * Combine initials + lastname
     */
    public function name(): Attribute
    {
        return Attribute::make(function (): string {
            return sprintf('%s %s', $this->initials, $this->lastname);
        })->shouldCache();
    }

    /**
     * Get User's initials for dashboard
     * Combine substr of firstname + lastname
     */
    public function initials(): Attribute
    {
        return Attribute::make(function (): string {
            return sprintf('%s%s', substr($this->firstname, 0, 1), substr($this->lastname, 0, 1));
        })->shouldCache();
    }

    /**
     * User belongTo Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    /**
     * User belongTo Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    /**
     * User belongTo Occupation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function occupation()
    {
        return $this->belongsTo(\App\Models\Occupation::class);
    }
}