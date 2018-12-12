<?php

use Core\Router\Router;

Router::add('/users', \Controller\UserController::class, 'list');
Router::add('/users/create', \Controller\UserController::class, 'create');
Router::add('/users/{id}/edit', \Controller\UserController::class, 'edit', ['id' => '\d+']);
Router::add('/users/{id}/delete', \Controller\UserController::class, 'delete', ['id' => '\d+']);
Router::add('/users/{user_id}/courses/{course_id}/grades', \Controller\UserController::class, 'delete', ['course_id' => '\d+','user_id' => '\d+' ]);
Router::add('/subjects', \Controller\SubjectController::class, 'list');
Router::add('/subjects/create', \Controller\SubjectController::class, 'create');
Router::add('/subjects/{id}/edit', \Controller\SubjectController::class, 'edit');
Router::add('/subjects/{id}/delete', \Controller\SubjectController::class, 'delete');
Router::add('/classes', \Controller\ClassController::class, 'list');
Router::add('/classes/create', \Controller\ClassController::class, 'create');
Router::add('/classes/{id}/edit', \Controller\ClassController::class, 'edit');
Router::add('/classes/{id}/delete', \Controller\ClassController::class, 'delete');
//TODO 1)авторизация через сессию (создать класс-обертку session) !!!
//TODO 2)доделать остальные части приложения
//TODO 3)написать меню