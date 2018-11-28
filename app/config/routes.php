<?php

use Core\Router\Router;

Router::add('/users', \Controller\UserController::class, 'list');
Router::add('/users/create', \Controller\UserController::class, 'create');
Router::add('/users/{id}/edit', \Controller\UserController::class, 'edit', ['id' => '\d+']);
Router::add('/users/{id}/delete', \Controller\UserController::class, 'delete', ['id' => '\d+']);
//Router::add('users/{user_id}/courses/{course_id}/grades', \Controller\UserController::class, 'delete', ['user_id' => '\d+', 'course_id' => '\d+']);