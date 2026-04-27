<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    private const CACHE_PREFIX = 'app_setting:';

    private const CACHE_TTL = 3600;

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember(
            self::CACHE_PREFIX.$key,
            self::CACHE_TTL,
            fn () => self::query()->where('key', $key)->value('value') ?? $default,
        );
    }

    public static function set(string $key, mixed $value): void
    {
        self::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );

        Cache::forget(self::CACHE_PREFIX.$key);
    }

    public static function forget(string $key): void
    {
        self::query()->where('key', $key)->delete();
        Cache::forget(self::CACHE_PREFIX.$key);
    }
}
