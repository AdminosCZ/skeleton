<?php

return [
    'resource' => [
        'label' => 'User',
        'plural_label' => 'Users',
        'navigation_label' => 'Users',
    ],
    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email verified at',
        'password' => 'Password',
        'password_edit_helper' => 'Leave blank to keep the current password.',
        'role' => 'Role',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'roles' => [
        'user' => 'User',
        'admin' => 'Administrator',
        'developer' => 'Developer',
    ],
];
