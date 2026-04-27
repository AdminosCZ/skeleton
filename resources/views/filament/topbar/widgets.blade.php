<div class="adminos-topbar-widgets">
    {{-- Datum + čas (Alpine, no server roundtrip — refresh každých 30s) --}}
    <div
        class="adminos-topbar-widget adminos-topbar-widget--datetime"
        x-data="{
            date: '',
            time: '',
            locale: '{{ app()->getLocale() === 'sk' ? 'sk-SK' : (app()->getLocale() === 'en' ? 'en-GB' : 'cs-CZ') }}',
            update() {
                const now = new Date();
                this.date = new Intl.DateTimeFormat(this.locale, {
                    weekday: 'short',
                    day: 'numeric',
                    month: 'long',
                }).format(now);
                this.time = new Intl.DateTimeFormat(this.locale, {
                    hour: '2-digit',
                    minute: '2-digit',
                }).format(now);
            },
        }"
        x-init="update(); setInterval(() => update(), 30000)"
        :title="date + ' · ' + time"
    >
        <x-filament::icon
            icon="heroicon-o-calendar"
            class="adminos-topbar-widget__icon-placeholder"
        />
        <span class="adminos-topbar-widget__label" x-text="date"></span>
        <span class="adminos-topbar-widget__separator">·</span>
        <span class="adminos-topbar-widget__value tabular-nums" x-text="time"></span>
    </div>

    {{-- Počasí (Livewire — server-side fetch s 30min cache) --}}
    @livewire(\App\Livewire\Topbar\WeatherWidget::class)
</div>
