<?php

return [
    'permissions' => [
        'receivable' => [
            'permission' => [
                'r',
            ],
            'guard' => ['web', 'sanctum'],
        ],
        'receivable payment' => [
            'permission' => [
                'c', 'r', 'u', 'd',
            ],
            'guard' => ['web', 'sanctum'],
        ],
    ],
];
