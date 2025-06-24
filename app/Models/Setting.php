<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'editable',
        'type',
        'key',
        'value',
        'comment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public $casts = [
        'editable' => 'boolean',
        'value'    => \App\Casts\SettingCast::class,
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'key';
    }

    /**
     * Get value for a key.
     *
     * @param  mixed|null  $default
     * @return mixed
     */
    public static function valueForKey(string $key, $default = null)
    {
        return \App\Helpers\Settings::get($key, $default);
    }

    /**
     * Update value for key.
     *
     * @param  mixed|null  $value
     * @return bool
     */
    public static function updateKey(string $key, $value = null)
    {
        return \App\Helpers\Settings::update($key, $value);
    }
}
