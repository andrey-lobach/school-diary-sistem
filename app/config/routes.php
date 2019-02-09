<?php

use Core\Router\Router;
Router::add('/my_profile', \Controller\UserController::class, 'profile');
Router::add('/users', \Controller\UserController::class, 'list');
Router::add('/users/create', \Controller\UserController::class, 'create');
Router::add('/users/{id}/edit', \Controller\UserController::class, 'edit', ['id' => '\d+']);
Router::add('/users/{id}/delete', \Controller\UserController::class, 'delete', ['id' => '\d+']);
Router::add('/classes', \Controller\ClassController::class, 'list');
Router::add('/my_class', \Controller\ClassController::class, 'listOfClass');
Router::add('/classes/create', \Controller\ClassController::class, 'create');
Router::add('/classes/{id}/edit', \Controller\ClassController::class, 'edit');
Router::add('/classes/{id}/delete', \Controller\ClassController::class, 'delete');
Router::add('/enrollment', \Controller\EnrollmentController::class, 'list');
Router::add('/enrollment/addStudent', \Controller\EnrollmentController::class, 'addStudent');
Router::add('/enrollment/addTeacher', \Controller\EnrollmentController::class, 'addTeacher');
Router::add(
    '/enrollment/{user_id}/{class_id}/delete',
    \Controller\EnrollmentController::class,
    'delete',
    ['user_id' => '\d+', 'class_id' => '\d+']
);
Router::add(
    '/enrollment/{user_id}/{class_id}/create',
    \Controller\EnrollmentController::class,
    'create',
    ['user_id' => '\d+', 'class_id' => '\d+']
);
Router::add('/login', \Controller\SecurityController::class, 'login');
Router::add('/logout', \Controller\SecurityController::class, 'logout');
Router::add('/', \Controller\SecurityController::class, 'login');


