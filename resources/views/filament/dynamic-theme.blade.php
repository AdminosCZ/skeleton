<?php
    use App\Filament\Pages\Settings\Branding;
    use App\Models\Setting;
    use Filament\Support\Colors\Color;

    $activeScheme = (string) Setting::get('branding.scheme', Branding::DEFAULT_SCHEME);
    $isMonochrome = $activeScheme === 'cerna';

    $lightPrimary = Branding::activeLightPrimary();
    $darkPrimary = Branding::activeDarkPrimary();

    $lightPalette = Color::hex($lightPrimary);
    $darkPalette = Color::hex($darkPrimary);

    /** Convert `#RRGGBB` → `R, G, B` triple for use inside `rgba(...)`. */
    $rgbTriple = static function (string $hex): string {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return implode(', ', [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ]);
    };

    $lightRgb = $rgbTriple($lightPrimary);
    $darkRgb = $rgbTriple($darkPrimary);
?>
<style id="adminos-dynamic-theme">
    /* Primary palette — both modes. */
    :root {
        @foreach ($lightPalette as $shade => $value)--primary-{{ $shade }}: {{ $value }};
        @endforeach
    }

    .dark {
        @foreach ($darkPalette as $shade => $value)--primary-{{ $shade }}: {{ $value }};
        @endforeach
    }

    /* Body gradient — radial blobs derived from the active scheme.
       Light gets a richer 4-blob composition so it carries the same depth
       as dark; the alpha values are tuned to read on a near-white base. */
    body {
        background-color: rgb(248 250 253);
        background-image:
            /* Hero blob top-right — strongest accent, sets the brand mood */
            radial-gradient(ellipse 75% 55% at 95% 0%,
                rgba({{ $lightRgb }}, 0.16) 0%, transparent 60%),
            /* Mirror blob bottom-left — anchors the diagonal */
            radial-gradient(ellipse 65% 55% at 0% 105%,
                rgba({{ $lightRgb }}, 0.12) 0%, transparent 60%),
            /* Top-left highlight — gives the canvas multi-source lighting */
            radial-gradient(ellipse 50% 45% at 0% 0%,
                rgba({{ $lightRgb }}, 0.08) 0%, transparent 65%),
            /* Soft mid wash — keeps the centre from feeling empty */
            radial-gradient(ellipse 70% 50% at 50% 55%,
                rgba({{ $lightRgb }}, 0.05) 0%, transparent 75%);
        background-attachment: fixed;
    }

    .dark body {
        background-color: rgb(8 8 10);
        background-image:
            radial-gradient(ellipse 65% 50% at 88% 0%,
                rgba({{ $darkRgb }}, 0.22) 0%, transparent 55%),
            radial-gradient(ellipse 55% 45% at 5% 105%,
                rgba({{ $darkRgb }}, 0.16) 0%, transparent 60%),
            radial-gradient(ellipse 60% 30% at 50% 50%,
                rgba({{ $darkRgb }}, 0.07) 0%, transparent 70%);
        background-attachment: fixed;
    }

@if ($isMonochrome)
    /* Apple monochrome — primary buttons go outline-only.
       Status buttons (success / danger / warning) keep their colour. */
    .fi-btn.fi-color-primary,
    .fi-ac-btn-action.fi-color-primary {
        background-color: transparent !important;
        background-image: none !important;
        color: rgb(23 23 23) !important;
        box-shadow: inset 0 0 0 1px rgb(23 23 23 / 0.4) !important;
    }

    .fi-btn.fi-color-primary:hover,
    .fi-ac-btn-action.fi-color-primary:hover {
        background-color: rgb(23 23 23 / 0.06) !important;
        box-shadow: inset 0 0 0 1px rgb(23 23 23 / 0.7) !important;
    }

    .dark .fi-btn.fi-color-primary,
    .dark .fi-ac-btn-action.fi-color-primary {
        color: rgb(250 250 250) !important;
        box-shadow: inset 0 0 0 1px rgb(250 250 250 / 0.4) !important;
    }

    .dark .fi-btn.fi-color-primary:hover,
    .dark .fi-ac-btn-action.fi-color-primary:hover {
        background-color: rgb(250 250 250 / 0.08) !important;
        box-shadow: inset 0 0 0 1px rgb(250 250 250 / 0.7) !important;
    }

    /* Primary links / table row actions — minimal underline accent */
    .fi-link.fi-color-primary {
        color: rgb(23 23 23) !important;
    }

    .dark .fi-link.fi-color-primary {
        color: rgb(250 250 250) !important;
    }
@endif
</style>
