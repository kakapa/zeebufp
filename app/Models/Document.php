<?php

namespace App\Models;

use App\Enums\DocumentStatusEnums;
use App\Enums\DocumentTypeEnums;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mime',
        'type',
        'size',
        'status',
        'path',
        'documentable_id',
        'documentable_type',
        'views',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'type' => DocumentTypeEnums::class,
        'status' => DocumentStatusEnums::class,
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
     * Document morphTo Client, Account, Payment, Claim.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}