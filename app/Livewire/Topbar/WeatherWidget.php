<?php

declare(strict_types=1);

namespace App\Livewire\Topbar;

use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class WeatherWidget extends \Livewire\Component
{
    private const CACHE_TTL_MINUTES = 30;

    public function placeholder(): string
    {
        return view('livewire.topbar.weather-widget-placeholder')->render();
    }

    public function render(): View
    {
        return view('livewire.topbar.weather-widget', [
            'weather' => $this->fetchWeather(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchWeather(): array
    {
        $apiKey = config('services.weather.key');
        $city = (string) Setting::get('weather_city', config('services.weather.default_city', 'Prague'));

        if (empty($apiKey)) {
            return [
                'available' => false,
                'reason' => 'api_missing',
                'city' => $city,
            ];
        }

        return Cache::remember(
            "weather:{$city}:".app()->getLocale(),
            now()->addMinutes(self::CACHE_TTL_MINUTES),
            fn (): array => $this->callApi($apiKey, $city),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function callApi(string $apiKey, string $city): array
    {
        try {
            $response = Http::timeout(5)
                ->get('https://api.openweathermap.org/data/2.5/weather', [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => app()->getLocale(),
                ]);
        } catch (Throwable) {
            return [
                'available' => false,
                'reason' => 'error',
                'city' => $city,
            ];
        }

        if ($response->status() === 404) {
            return [
                'available' => false,
                'reason' => 'unknown_city',
                'city' => $city,
            ];
        }

        if (! $response->ok()) {
            return [
                'available' => false,
                'reason' => 'error',
                'city' => $city,
            ];
        }

        $data = $response->json();

        return [
            'available' => true,
            'temperature' => (int) round((float) ($data['main']['temp'] ?? 0)),
            'description' => (string) ($data['weather'][0]['description'] ?? ''),
            'icon' => (string) ($data['weather'][0]['icon'] ?? '01d'),
            'city' => (string) ($data['name'] ?? $city),
        ];
    }
}
