<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case User = 'user';
    case Admin = 'admin';
    case Developer = 'developer';

    public function canChangeAppSettings(): bool
    {
        return match ($this) {
            self::Admin, self::Developer => true,
            self::User => false,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::User => __('users.roles.user'),
            self::Admin => __('users.roles.admin'),
            self::Developer => __('users.roles.developer'),
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::User->value => __('users.roles.user'),
            self::Admin->value => __('users.roles.admin'),
            self::Developer->value => __('users.roles.developer'),
        ];
    }
}
