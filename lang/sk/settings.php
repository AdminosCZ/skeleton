<?php

return [
    'navigation' => [
        'group' => 'Nastavenia',
        'general' => 'Všeobecné',
        'branding' => 'Branding',
    ],
    'general' => [
        'title' => 'Všeobecné nastavenia',
        'subheading' => 'Základná konfigurácia administrácie. Zmeny sa prejavia po uložení pre všetkých používateľov.',
        'fields' => [
            'locale' => 'Jazyk administrácie',
            'locale_helper' => 'Jazyk, ktorý uvidia všetci používatelia admin panelu.',
            'weather_city' => 'Mesto pre počasie',
            'weather_city_helper' => 'Mesto, ktorého aktuálne počasie sa zobrazí v hornej lište. Anglický názov zvyčajne funguje najlepšie (Prague, Bratislava, Brno).',
        ],
        'saved' => 'Nastavenia uložené.',
    ],
    'locales' => [
        'cs' => 'Čeština',
        'sk' => 'Slovenčina',
        'en' => 'English',
    ],
    'branding' => [
        'title' => 'Branding',
        'subheading' => 'Vlastné logo a farebná schéma administrácie. Ak necháte predvolené, použije sa ADMINOS branding.',
        'logos' => [
            'title' => 'Logá a favicon',
            'description' => 'Odporúčaný pomer loga je ~4:1 (napr. 320×80, 480×120). PNG, SVG, WebP alebo JPEG. Maximum 1 MB. Favicon do 256 KB.',
        ],
        'scheme' => [
            'title' => 'Farebná schéma',
            'description' => 'Vyber farbu, ktorá sa použije pre tlačidlá, aktívnu položku v menu, focus ringy, gradienty a ďalšie akcenty. Rovnaká voľba sa aplikuje na svetlý aj tmavý režim.',
        ],
        'fields' => [
            'logo_light' => 'Logo (svetlý režim)',
            'logo_light_helper' => 'Tmavý text na svetlom pozadí.',
            'logo_dark' => 'Logo (tmavý režim)',
            'logo_dark_helper' => 'Svetlý text na tmavom pozadí. Ak necháte prázdne, použije sa logo pre svetlý režim.',
            'favicon' => 'Favicon',
            'favicon_helper' => 'Štvorcová ikona pre záložku prehliadača (PNG, SVG, ICO).',
        ],
        'upload' => [
            'placeholder' => 'Pretiahnite sem súbor alebo <span class="filepond--label-action">Nahrať</span>',
        ],
        'saved' => 'Branding uložený.',
        'reset' => 'Branding vrátený na predvolený ADMINOS.',
        'actions' => [
            'reset' => 'Vrátiť ADMINOS branding',
            'reset_confirm' => [
                'heading' => 'Vrátiť ADMINOS branding?',
                'description' => 'Zmaže nahrané logo a favicon, vráti predvolenú schému. Akciu nemožno vrátiť späť.',
            ],
        ],
    ],
];
