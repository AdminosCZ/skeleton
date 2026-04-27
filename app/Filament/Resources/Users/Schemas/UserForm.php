<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('users.fields.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('users.fields.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                Select::make('role')
                    ->label(__('users.fields.role'))
                    ->options(UserRole::options())
                    ->default(UserRole::User->value)
                    ->native(false)
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label(__('users.fields.email_verified_at')),
                TextInput::make('password')
                    ->label(__('users.fields.password'))
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->helperText(fn (string $operation): ?string => $operation === 'edit'
                        ? __('users.fields.password_edit_helper')
                        : null),
            ]);
    }
}
