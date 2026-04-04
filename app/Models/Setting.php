<?php
// app/Models/Setting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'is_public'
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    // Get setting value by key
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Set setting value (update or create)
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        $setting = self::where('key', $key)->first();

        if ($setting) {
            // Update existing
            $setting->update([
                'value' => $value,
                'type' => $type,
                'group' => $group
            ]);
            return $setting;
        } else {
            // Create new
            return self::create([
                'key' => $key,
                'value' => $value,
                'type' => $type,
                'group' => $group
            ]);
        }
    }

    // Get all settings by group
    public static function getGroup($group)
    {
        return self::where('group', $group)->get()->pluck('value', 'key');
    }
}
