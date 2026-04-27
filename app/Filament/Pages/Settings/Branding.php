<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

/**
 * @property-read \Filament\Schemas\Schema $form
 */
class Branding extends Page
{
    protected string $view = 'filament.pages.settings.branding';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?int $navigationSort = 110;

    /**
     * Pre-baked colour schemes. Each scheme drives both modes:
     *   primary_light → applied as Filament's panel `primary` palette in light
     *   primary_dark  → injected as `.dark { --primary-N: ... }` overrides
     *
     * For chromatic schemes light = dark (same hue, Filament/CSS handles tonal
     * shifts via the generated 50…950 palette). The "Černá" scheme intentionally
     * inverts: black accent in light, white accent in dark — proper monochrome.
     *
     * Swatches paint a circle in the Radio option using the LIGHT primary
     * (or, for Černá, a 50/50 split so users see both ends of the inversion).
     */
    public const SCHEMES = [
        'modra' => [
            'label' => 'Modrá',
            'primary_light' => '#0085FE',
            'primary_dark' => '#0085FE',
            'swatch' => '#0085FE',
        ],
        'zelena' => [
            'label' => 'Zelená',
            'primary_light' => '#22C55E',
            'primary_dark' => '#22C55E',
            'swatch' => '#22C55E',
        ],
        'cervena' => [
            'label' => 'Červená',
            'primary_light' => '#EB4143',
            'primary_dark' => '#EB4143',
            'swatch' => '#EB4143',
        ],
        'magenta' => [
            'label' => 'Magenta',
            'primary_light' => '#D946EF',
            'primary_dark' => '#D946EF',
            'swatch' => '#D946EF',
        ],
        'cerna' => [
            'label' => 'Černá',
            'primary_light' => '#171717', /* neutral-900 — true monochrome, no slate undertone */
            'primary_dark' => '#FAFAFA',  /* neutral-50  — pure white-ish */
            'swatch' => 'linear-gradient(90deg, #171717 0%, #171717 50%, #FAFAFA 50%, #FAFAFA 100%)',
        ],
    ];

    public const DEFAULT_SCHEME = 'cervena';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'logo_light_path' => Setting::get('branding.logo_light_path'),
            'logo_dark_path' => Setting::get('branding.logo_dark_path'),
            'favicon_path' => Setting::get('branding.favicon_path'),
            'scheme' => Setting::get('branding.scheme', self::DEFAULT_SCHEME),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('settings.branding.logos.title'))
                    ->description(__('settings.branding.logos.description'))
                    ->columns(3)
                    ->schema([
                        FileUpload::make('logo_light_path')
                            ->label(__('settings.branding.fields.logo_light'))
                            ->helperText(self::helperWithIcon(__('settings.branding.fields.logo_light_helper')))
                            ->placeholder(__('settings.branding.upload.placeholder'))
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->maxSize(1024)
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                            ->imagePreviewHeight('100')
                            ->extraAttributes(['class' => 'adminos-file-upload']),

                        FileUpload::make('logo_dark_path')
                            ->label(__('settings.branding.fields.logo_dark'))
                            ->helperText(self::helperWithIcon(__('settings.branding.fields.logo_dark_helper')))
                            ->placeholder(__('settings.branding.upload.placeholder'))
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->maxSize(1024)
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                            ->imagePreviewHeight('100')
                            ->extraAttributes(['class' => 'adminos-file-upload']),

                        FileUpload::make('favicon_path')
                            ->label(__('settings.branding.fields.favicon'))
                            ->helperText(self::helperWithIcon(__('settings.branding.fields.favicon_helper')))
                            ->placeholder(__('settings.branding.upload.placeholder'))
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->maxSize(256)
                            ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/x-icon', 'image/vnd.microsoft.icon'])
                            ->imagePreviewHeight('100')
                            ->extraAttributes(['class' => 'adminos-file-upload']),
                    ]),

                Section::make(__('settings.branding.scheme.title'))
                    ->description(__('settings.branding.scheme.description'))
                    ->schema([
                        Radio::make('scheme')
                            ->hiddenLabel()
                            ->options(self::schemeOptions())
                            ->required()
                            ->default(self::DEFAULT_SCHEME)
                            ->columns(5)
                            ->extraAttributes(['class' => 'adminos-scheme-radio-grid']),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::set('branding.logo_light_path', $state['logo_light_path'] ?: null);
        Setting::set('branding.logo_dark_path', $state['logo_dark_path'] ?: null);
        Setting::set('branding.favicon_path', $state['favicon_path'] ?: null);
        Setting::set('branding.scheme', $state['scheme']);

        Notification::make()
            ->title(__('settings.branding.saved'))
            ->success()
            ->send();

        $this->redirect(static::getUrl(), navigate: false);
    }

    public function resetToDefaultsAction(): Action
    {
        return Action::make('resetToDefaults')
            ->label(__('settings.branding.actions.reset'))
            ->icon(Heroicon::OutlinedArrowPath)
            ->color('gray')
            ->requiresConfirmation()
            ->modalHeading(__('settings.branding.actions.reset_confirm.heading'))
            ->modalDescription(__('settings.branding.actions.reset_confirm.description'))
            ->action(function (): void {
                foreach (['logo_light_path', 'logo_dark_path', 'favicon_path'] as $key) {
                    if ($path = Setting::get("branding.{$key}")) {
                        Storage::disk('public')->delete($path);
                    }
                    Setting::forget("branding.{$key}");
                }

                Setting::forget('branding.scheme');

                Notification::make()
                    ->title(__('settings.branding.reset'))
                    ->success()
                    ->send();

                $this->redirect(static::getUrl(), navigate: false);
            });
    }

    public static function canAccess(): bool
    {
        return Gate::allows('change-app-settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('settings.navigation.branding');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('settings.navigation.group');
    }

    public function getTitle(): string|Htmlable
    {
        return __('settings.branding.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('settings.branding.subheading');
    }

    /**
     * @return array{primary_light: string, primary_dark: string}
     */
    public static function activeScheme(): array
    {
        $key = (string) Setting::get('branding.scheme', self::DEFAULT_SCHEME);
        $scheme = self::SCHEMES[$key] ?? self::SCHEMES[self::DEFAULT_SCHEME];

        return [
            'primary_light' => $scheme['primary_light'],
            'primary_dark' => $scheme['primary_dark'],
        ];
    }

    public static function activeLightPrimary(): string
    {
        return self::activeScheme()['primary_light'];
    }

    public static function activeDarkPrimary(): string
    {
        return self::activeScheme()['primary_dark'];
    }

    /**
     * Wrap helper text in a dim, info-icon-prefixed HTML span so it stands
     * apart from regular field copy.
     */
    private static function helperWithIcon(string $text): HtmlString
    {
        return new HtmlString(
            '<span class="adminos-helper">'
                .'<svg class="adminos-helper__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">'
                .'<path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />'
                .'</svg>'
                .'<span>'.e($text).'</span>'
                .'</span>'
        );
    }

    /**
     * @return array<string, \Illuminate\Contracts\Support\Htmlable>
     */
    private static function schemeOptions(): array
    {
        $options = [];

        foreach (self::SCHEMES as $key => $scheme) {
            $options[$key] = new HtmlString(sprintf(
                '<span class="adminos-scheme-option">'
                    .'<span class="adminos-scheme-option__swatch" style="background:%s"></span>'
                    .'<span class="adminos-scheme-option__label">%s</span>'
                    .'</span>',
                e($scheme['swatch']),
                e($scheme['label']),
            ));
        }

        return $options;
    }
}
