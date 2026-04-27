<?php

return [
    'navigation' => [
        'group' => 'Settings',
        'general' => 'General',
        'branding' => 'Branding',
    ],
    'general' => [
        'title' => 'General settings',
        'subheading' => 'Core configuration of the admin panel. Changes apply to every user after save.',
        'fields' => [
            'locale' => 'Admin language',
            'locale_helper' => 'The language every admin panel user will see.',
            'weather_city' => 'Weather city',
            'weather_city_helper' => 'The city whose current weather appears in the topbar. The English name usually works best (Prague, Bratislava, Brno).',
        ],
        'saved' => 'Settings saved.',
    ],
    'locales' => [
        'cs' => 'Čeština',
        'sk' => 'Slovenčina',
        'en' => 'English',
    ],
    'branding' => [
        'title' => 'Branding',
        'subheading' => 'Custom logo and colour scheme. Keep the defaults to use the ADMINOS branding.',
        'logos' => [
            'title' => 'Logos & favicon',
            'description' => 'Recommended logo ratio is ~4:1 (e.g. 320×80, 480×120). PNG, SVG, WebP or JPEG. Max 1 MB. Favicon up to 256 KB.',
        ],
        'scheme' => [
            'title' => 'Colour scheme',
            'description' => 'Pick the colour used for buttons, active menu items, focus rings, gradients and other accents. The same choice applies to both light and dark modes.',
        ],
        'fields' => [
            'logo_light' => 'Logo (light mode)',
            'logo_light_helper' => 'Dark text on light background.',
            'logo_dark' => 'Logo (dark mode)',
            'logo_dark_helper' => 'Light text on dark background. Falls back to the light-mode logo when empty.',
            'favicon' => 'Favicon',
            'favicon_helper' => 'Square icon for the browser tab (PNG, SVG, ICO).',
        ],
        'upload' => [
            'placeholder' => 'Drop a file here or <span class="filepond--label-action">Upload</span>',
        ],
        'saved' => 'Branding saved.',
        'reset' => 'Branding reset to ADMINOS defaults.',
        'actions' => [
            'reset' => 'Reset to ADMINOS branding',
            'reset_confirm' => [
                'heading' => 'Reset to ADMINOS branding?',
                'description' => 'Deletes uploaded logo and favicon, resets the colour scheme. This cannot be undone.',
            ],
        ],
    ],
];
