<?php

namespace App\Models;

use App\Enums\ClientGenderEnums;
use App\Enums\ClientSourceEnums;
use App\Enums\ClientStatusEnums;
use App\Enums\ClientTitleEnums;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory, HasUlids, Notifiable;

    /**
     * The attributes that are guarded from mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => ClientStatusEnums::class,
        'title' => ClientTitleEnums::class,
        'gender' => ClientGenderEnums::class,
        'referral_source' => ClientSourceEnums::class,
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get User's full name.
     */
    public function name(): Attribute
    {
        return Attribute::make(function (): string {
            if ($this->middlename) {
                return sprintf(
                    '%s %s %s',
                    $this->firstname,
                    $this->middlename,
                    $this->lastname
                );
            }

            return sprintf('%s %s', $this->firstname, $this->lastname);
        })->shouldCache();
    }

    /**
     * Client hasMany Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function accounts()
    {
        return $this->hasMany(\App\Models\Account::class);
    }

    /**
     * Summary of activities
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<Activity, Account>
     */
    public function activities()
    {
        return $this->morphMany(\App\Models\Activity::class, 'activityable');
    }

    /**
     * Summary of documents
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<Activity, Account>
     */
    public function documents()
    {
        return $this->morphMany(\App\Models\Document::class, 'documentable');
    }
}
