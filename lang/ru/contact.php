<?php

return [
    'office' => [
        'title' => 'Офис',
        'city' => 'Аван, Ереван',
        'email' => 'Email',
        'phone' => 'Телефон',
        'map' => 'Открыть в Google Maps',
    ],

    'form' => [
        'title' => 'Отправить сообщение',
        'name' => 'Ваше имя',
        'company' => 'Компания',
        'email' => 'Email',
        'phone' => 'Телефон',
        'optional' => 'Необязательно',
        'package' => 'Пакет',
        'package_unsure' => 'Пока не знаю',
        'message' => 'Сообщение',
        'message_hint' => 'Пара строк о вашем бизнесе и целях.',
        'submit' => 'Отправить',
        'errors' => [
            'name' => 'Введите ваше имя.',
            'email' => 'Введите корректный email.',
            'message' => 'Расскажите немного о проекте.',
        ],
        // TODO: remove once the form is connected to a mail service.
        'not_connected' => 'Онлайн-отправка пока не подключена. Напишите нам на hello@imust.am.',
    ],
];
