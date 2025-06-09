<?php

namespace App\Models;

use App\Enums\AccountStatusEnums;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'package_id',
        'payday',
        'package_id',
        'status',
        'total_coverage_amount',
        'last_payment_at',
        'next_payment_at',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => AccountStatusEnums::class,
        'last_payment_at' => 'date',
        'next_payment_at' => 'date'
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
     * Account belongsTo Client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    /**
     * Account belongsTo Package.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class);
    }
}