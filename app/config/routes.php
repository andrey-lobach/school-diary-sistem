<?php

use Core\Router\Router;

Router::add('/users', \Controller\UserController::class, 'list');
//Router::add('users/new', \Controller\UserController::class, 'create');
//Router::add('users/{id}/edit', \Controller\UserController::class, 'edit', ['id' => '\d+']);
//Router::add('users/{id}/delete', \Controller\UserController::class, 'delete', ['id' => '\d+'])