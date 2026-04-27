<div wire:poll.300s
     class="adminos-topbar-widget adminos-topbar-widget--weather"
     @class([
         'adminos-topbar-widget--unavailable' => ! $weather['available'],
     ])
     @if ($weather['available'])
         title="{{ $weather['description'] }}, {{ $weather['city'] }}"
     @else
         title="{{ __('topbar.weather.'.$weather['reason'], ['city' => $weather['city']]) }}"
     @endif
>
    @if ($weather['available'])
        <img
            src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png"
            alt=""
            class="adminos-topbar-widget__icon"
            loading="lazy"
            width="32"
            height="32"
        />
        <span class="adminos-topbar-widget__value tabular-nums">
            {{ $weather['temperature'] }}°
        </span>
        <span class="adminos-topbar-widget__label">
            {{ $weather['city'] }}
        </span>
    @else
        <x-filament::icon
            icon="heroicon-o-cloud"
            class="adminos-topbar-widget__icon-placeholder"
        />
        <span class="adminos-topbar-widget__value">—</span>
        <span class="adminos-topbar-widget__label">
            {{ $weather['city'] }}
        </span>
    @endif
</div>
