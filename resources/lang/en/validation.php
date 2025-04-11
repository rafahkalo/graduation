<?php

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],

    'confirmed' => 'The :attribute confirmation does not match.',
    'password' => [
        'min' => 'The password must be at least :min characters.',
        'regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        'strong' => 'The password is too weak.',
    ],
    'attributes' => [
        'email' => 'email',
        'password' => 'password',
    ],

    'saudi_phone_invalid' => 'your phone number is invalid',
];
