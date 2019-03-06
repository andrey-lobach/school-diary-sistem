<?php
return [
    'parameters' => [
        'database' => [
            'dsn' => 'mysql:host=localhost; dbname=Diary',
            'user' => 'root',
            'password' => 'YjdsqgfhjkM_2'
        ],
        'menu' => require __DIR__.'/menu.php',
        'security' => require __DIR__.'/security.php',
        'template_dir' => __DIR__.'/../views',
    ],
    'services' => require __DIR__ . '/services.php',
];
//TODO code formatting(php doc!!!) redirect url with '/' to without '/'
//TODO style (teacher leave/join class)
//TODO style in class list