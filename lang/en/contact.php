<?php

return [
    'office' => [
        'title' => 'Office',
        'city' => 'Avan, Yerevan',
        'email' => 'Email',
        'phone' => 'Phone',
        'map' => 'Open in Google Maps',
    ],

    'form' => [
        'title' => 'Send a message',
        'name' => 'Your name',
        'company' => 'Company',
        'email' => 'Email',
        'phone' => 'Phone',
        'optional' => 'Optional',
        'package' => 'Package',
        'package_unsure' => 'Not sure yet',
        'message' => 'Message',
        'message_hint' => 'A few lines about your business and what you want to achieve.',
        'submit' => 'Send message',
        'errors' => [
            'name' => 'Enter your name.',
            'email' => 'Enter a valid email address.',
            'message' => 'Tell us a little about your project.',
        ],
        // TODO: remove once the form is connected to a mail service.
        'not_connected' => 'Online sending is not set up yet. Please email us at hello@imust.am.',
    ],
];
