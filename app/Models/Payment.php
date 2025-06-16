<?php

namespace App\Models;

use App\Enums\PaymentMethodEnums;
use App\Enums\PaymentStatusEnums;
use App\Enums\PaymentTypeEnums;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuids;

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
        'paid_at' => 'datetime',
        'pay_at' => 'date',
        'status' => PaymentStatusEnums::class,
        'type' => PaymentTypeEnums::class,
        'method' => PaymentMethodEnums::class
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
     * Payment belongsTo Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class);
    }

    /**
     * Payment belongsTo Claim.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function claim()
    {
        return $this->belongsTo(\App\Models\Claim::class);
    }
}