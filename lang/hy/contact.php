<?php

return [
    'office' => [
        'title' => 'Գրասենյակ',
        'city' => 'Ավան, Երևան',
        'email' => 'Էլ. փոստ',
        'phone' => 'Հեռախոս',
        'map' => 'Բացել Google Maps-ում',
    ],

    'form' => [
        'title' => 'Ուղարկել հաղորդագրություն',
        'name' => 'Ձեր անունը',
        'company' => 'Ընկերություն',
        'email' => 'Էլ. փոստ',
        'phone' => 'Հեռախոս',
        'optional' => 'Ոչ պարտադիր',
        'package' => 'Փաթեթ',
        'package_unsure' => 'Դեռ չգիտեմ',
        'message' => 'Հաղորդագրություն',
        'message_hint' => 'Մի քանի տող ձեր բիզնեսի և նպատակների մասին։',
        'submit' => 'Ուղարկել',
        'errors' => [
            'name' => 'Մուտքագրեք ձեր անունը։',
            'email' => 'Մուտքագրեք ճիշտ էլ. հասցե։',
            'message' => 'Պատմեք մի փոքր ձեր նախագծի մասին։',
        ],
        // TODO: remove once the form is connected to a mail service.
        'not_connected' => 'Առցանց ուղարկումը դեռ միացված չէ։ Խնդրում ենք գրել hello@imust.am հասցեին։',
    ],
];
