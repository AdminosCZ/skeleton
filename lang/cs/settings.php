<?php

return [
    'navigation' => [
        'group' => 'Nastavení',
        'general' => 'Obecné',
        'branding' => 'Branding',
    ],
    'general' => [
        'title' => 'Obecné nastavení',
        'subheading' => 'Základní konfigurace administrace. Změny se projeví po uložení pro všechny uživatele.',
        'fields' => [
            'locale' => 'Jazyk administrace',
            'locale_helper' => 'Jazyk, který uvidí všichni uživatelé admin panelu.',
            'weather_city' => 'Město pro počasí',
            'weather_city_helper' => 'Město, jehož aktuální počasí se zobrazí v horní liště. Anglický název obvykle funguje nejlépe (Prague, Bratislava, Brno).',
        ],
        'saved' => 'Nastavení uloženo.',
    ],
    'locales' => [
        'cs' => 'Čeština',
        'sk' => 'Slovenčina',
        'en' => 'English',
    ],
    'branding' => [
        'title' => 'Branding',
        'subheading' => 'Vlastní logo a barevné schéma administrace. Pokud necháte výchozí, použije se ADMINOS branding.',
        'logos' => [
            'title' => 'Loga a favicon',
            'description' => 'Doporučený poměr loga je ~4:1 (např. 320×80, 480×120). PNG, SVG, WebP nebo JPEG. Maximum 1 MB. Favicon do 256 KB.',
        ],
        'scheme' => [
            'title' => 'Barevné schéma',
            'description' => 'Vyber barvu, která se použije pro tlačítka, aktivní položku v menu, focus ringy, gradienty a další akcenty. Stejná volba se aplikuje na světlý i tmavý režim.',
        ],
        'fields' => [
            'logo_light' => 'Logo (světlý režim)',
            'logo_light_helper' => 'Tmavý text na světlém pozadí.',
            'logo_dark' => 'Logo (tmavý režim)',
            'logo_dark_helper' => 'Světlý text na tmavém pozadí. Pokud necháte prázdné, použije se logo pro světlý režim.',
            'favicon' => 'Favicon',
            'favicon_helper' => 'Čtvercová ikona pro záložku prohlížeče (PNG, SVG, ICO).',
        ],
        'upload' => [
            'placeholder' => 'Přetáhněte sem soubor nebo <span class="filepond--label-action">Nahrát</span>',
        ],
        'saved' => 'Branding uložen.',
        'reset' => 'Branding vrácen na výchozí ADMINOS.',
        'actions' => [
            'reset' => 'Vrátit ADMINOS branding',
            'reset_confirm' => [
                'heading' => 'Vrátit ADMINOS branding?',
                'description' => 'Smaže nahrané logo a favicon, vrátí výchozí barevné schéma. Akci nelze vzít zpět.',
            ],
        ],
    ],
];
