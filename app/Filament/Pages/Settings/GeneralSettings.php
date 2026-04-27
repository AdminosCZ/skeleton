<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Gate;

/**
 * @property-read \Filament\Schemas\Schema $form
 */
class GeneralSettings extends Page
{
    protected string $view = 'filament.pages.settings.general';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 100;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'locale' => Setting::get('locale', config('app.locale', 'cs')),
            'weather_city' => Setting::get('weather_city', config('services.weather.default_city', 'Prague')),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('locale')
                    ->label(__('settings.general.fields.locale'))
                    ->helperText(__('settings.general.fields.locale_helper'))
                    ->options(__('settings.locales'))
                    ->native(false)
                    ->required(),
                TextInput::make('weather_city')
                    ->label(__('settings.general.fields.weather_city'))
                    ->helperText(__('settings.general.fields.weather_city_helper'))
                    ->maxLength(120)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::set('locale', $state['locale']);
        Setting::set('weather_city', trim((string) $state['weather_city']));

        // Apply the new locale to this response so the flashed notification
        // renders in the target language, then redirect so the full page
        // reloads through middleware and picks up every translation.
        app()->setLocale($state['locale']);

        Notification::make()
            ->title(__('settings.general.saved'))
            ->success()
            ->send();

        $this->redirect(static::getUrl(), navigate: false);
    }

    public static function canAccess(): bool
    {
        return Gate::allows('change-app-settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('settings.navigation.general');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('settings.navigation.group');
    }

    public function getTitle(): string|Htmlable
    {
        return __('settings.general.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('settings.general.subheading');
    }
}
