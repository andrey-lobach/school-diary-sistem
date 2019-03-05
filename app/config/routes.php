<?php

use Core\Router\Router;

Router::add('/my-profile', \Controller\UserController::class, 'profile');
Router::add('/users', \Controller\UserController::class, 'list');
Router::add('/users\?{query}', \Controller\UserController::class, 'list', ['query' => '\S+']);
Router::add('/users/create', \Controller\UserController::class, 'create');
Router::add('/users/{id}/edit', \Controller\UserController::class, 'edit', ['id' => '\d+']);
Router::add('/users/{id}/delete', \Controller\UserController::class, 'delete', ['id' => '\d+']);
Router::add('/classes', \Controller\ClassController::class, 'list');
Router::add('/my-class', \Controller\ClassController::class, 'listOfClass');
Router::add('/classes/create', \Controller\ClassController::class, 'create');
Router::add('/classes/{id}', \Controller\ClassController::class, 'listOfClass', ['id' => '\d+']);
Router::add('/classes/{id}/edit', \Controller\ClassController::class, 'edit');
Router::add('/classes/{id}/delete', \Controller\ClassController::class, 'delete');
Router::add('/classes/{id}/add-student', \Controller\EnrollmentController::class, 'addStudent', ['id' => '\d+']);
Router::add('/classes/{id}/add-teacher', \Controller\EnrollmentController::class, 'addTeacher', ['id' => '\d+']);
Router::add('/classes/{id}/join-class', \Controller\ClassController::class, 'joinClass', ['id' => '\d+']);
Router::add('/classes/{id}/leave-class', \Controller\ClassController::class, 'leaveClass', ['id' => '\d+']);
Router::add(
    '/enrollment/{user_id}/{class_id}/delete',
    \Controller\EnrollmentController::class,
    'delete',
    ['user_id' => '\d+', 'class_id' => '\d+']
);

Router::add('/login', \Controller\SecurityController::class, 'login');
Router::add('/logout', \Controller\SecurityController::class, 'logout');
Router::add('/', \Controller\SecurityController::class, 'login');


