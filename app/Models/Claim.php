<?php

namespace App\Models;

use App\Enums\ClaimStatusEnums;
use App\Enums\ClaimTypeEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

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
        'submission_at' => 'date',
        'type' => ClaimTypeEnums::class,
        'status' => ClaimStatusEnums::class
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
     * Claim belongsTo Client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    /**
     * Claim belongsTo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}