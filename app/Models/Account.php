<?php

namespace App\Models;

use App\Enums\AccountStatusEnums;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'payday',
        'status',
        'total_contribution_amount',
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
     * Account belongsToMany Package.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function packages()
    {
        return $this->belongsToMany(\App\Models\Package::class);
    }
}
