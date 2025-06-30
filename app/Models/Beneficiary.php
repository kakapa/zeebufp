<?php

namespace App\Models;

use App\Enums\BeneficiaryRelationshipEnums;
use App\Enums\ClientGenderEnums;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory, HasUlids;

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
        'gender' => ClientGenderEnums::class,
        'relationship' => BeneficiaryRelationshipEnums::class,
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Get User's name for dashboard
     * Combine initials + lastname
     */
    public function name(): Attribute
    {
        return Attribute::make(function (): string {
            return sprintf('%s %s %s', $this->firstname, $this->middlename , $this->lastname);
        })->shouldCache();
    }

    /**
     * Beneficiary belongsTo Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class);
    }
}