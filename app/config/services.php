<?php
return [
    \Controller\ClassController::class      => [
        \Model\ClassModel::class,
        \Model\UserModel::class,
        \Core\Template\Renderer::class,
        \Service\SecurityService::class,
        \Model\EnrollmentModel::class,
    ],
    \Controller\SecurityController::class   => [
        \Service\SecurityService::class,
        \Core\HTTP\SessionProvider::class,
        \Core\Template\Renderer::class,
    ],
    \Controller\UserController::class       => [
        \Model\UserModel::class,
        \Core\Template\Renderer::class,
        \Service\SecurityService::class,
    ],
    \Controller\EnrollmentController::class => [
        \Model\EnrollmentModel::class,
        \Model\ClassModel::class,
        \Model\UserModel::class,
        \Core\Template\Renderer::class,
        \Service\SecurityService::class,
    ],
    \Core\DB\Connection::class              => ['%database%'],
    \Core\Template\MenuBuilder::class       => ['%menu%', \Service\SecurityService::class],
    \Core\Template\Renderer::class          => ['%template_dir%', \Core\Template\MenuBuilder::class],
    \Core\Security\Guardian::class          => [\Middleware\GuestMiddleware::class, \Middleware\RoleMiddleware::class],
    \Model\UserModel::class                 => [
        \Core\DB\Connection::class,
        \Core\Security\PasswordHelper::class,
        \Core\Security\StringBuilder::class,
    ],
    \Model\ClassModel::class                => [\Core\DB\Connection::class],
    \Model\EnrollmentModel::class           => [\Core\DB\Connection::class],
    \Service\SecurityService::class         => [
        \Core\HTTP\SessionProvider::class,
        \Model\UserModel::class,
        \Core\Security\PasswordHelper::class,
    ],
    \Middleware\GuestMiddleware::class      => [\Service\SecurityService::class],
    \Middleware\RoleMiddleware::class       => ['%security%', \Service\SecurityService::class],
];