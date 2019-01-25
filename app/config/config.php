<?php
return [
    'parameters' => [
        'database' => [
            'dsn' => 'mysql:host=localhost; dbname=Diary',
            'user' => 'root',
            'password' => 'YjdsqgfhjkM_2'
        ],
        'security' => require __DIR__.'/security.php'
    ],
    'services' => require __DIR__ . '/services.php',
];