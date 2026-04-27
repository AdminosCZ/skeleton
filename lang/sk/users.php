<?php

return [
    'resource' => [
        'label' => 'Používateľ',
        'plural_label' => 'Používatelia',
        'navigation_label' => 'Používatelia',
    ],
    'fields' => [
        'name' => 'Meno',
        'email' => 'Email',
        'email_verified_at' => 'Email overený',
        'password' => 'Heslo',
        'password_edit_helper' => 'Nechajte prázdne, ak nechcete meniť heslo.',
        'role' => 'Rola',
        'created_at' => 'Vytvorené',
        'updated_at' => 'Upravené',
    ],
    'roles' => [
        'user' => 'Používateľ',
        'admin' => 'Administrátor',
        'developer' => 'Vývojár',
    ],
];
