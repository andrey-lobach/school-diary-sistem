<?php

    require_once __DIR__.'/../src/Core/Autoloader.php';
    $autoloader = new \Core\Autoloader([
        __DIR__.'/../src/',
        __DIR__
    ]);
    spl_autoload_register([$autoloader, 'load']);