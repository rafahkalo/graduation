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

    'status_change_not_allowed' => 'You cannot change the status to "pending" after it has been rejected.',
    'status_updated_success' => 'The status has been updated successfully.',
    'coupon_not_found' => 'The coupon does not exist.',
    'coupon_inactive' => 'The coupon is inactive.',
    'coupon_not_started' => 'The coupon has not started yet.',
    'coupon_expired' => 'The coupon has expired.',
    'coupon_max_uses' => 'The coupon has reached its maximum uses.',
    'coupon_user_max_uses' => 'The user has reached the maximum uses for this coupon.',
    'custom' => [
        'people_count' => [
            'exceeds_unit_limit' => 'The number of people exceeds the allowed limit for the unit.',
        ],
    ],
];
