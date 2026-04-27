<?php

return [
    'resource' => [
        'label' => 'Uživatel',
        'plural_label' => 'Uživatelé',
        'navigation_label' => 'Uživatelé',
    ],
    'fields' => [
        'name' => 'Jméno',
        'email' => 'Email',
        'email_verified_at' => 'Email ověřen',
        'password' => 'Heslo',
        'password_edit_helper' => 'Nechte prázdné, pokud nechcete měnit heslo.',
        'role' => 'Role',
        'created_at' => 'Vytvořeno',
        'updated_at' => 'Upraveno',
    ],
    'roles' => [
        'user' => 'Uživatel',
        'admin' => 'Administrátor',
        'developer' => 'Vývojář',
    ],
];
