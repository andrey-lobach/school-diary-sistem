<?php
return [
    \Controller\ClassController::class => [\Model\ClassModel::class],
    \Controller\SecurityController::class => [\Service\SecurityService::class, \Core\HTTP\SessionProvider::class],
    \Controller\SubjectController::class => [\Model\SubjectModel::class],
    \Controller\UserController::class => [\Model\UserModel::class],
    \Core\DB\Connection::class => ['%database%'],
    \Model\UserModel::class => [\Core\DB\Connection::class, \Core\Security\PasswordHelper::class, \Core\Security\StringBuilder::class],
    \Model\SubjectModel::class=>[\Core\DB\Connection::class],
    \Model\ClassModel::class=>[\Core\DB\Connection::class],
    \Service\SecurityService::class => [\Core\HTTP\SessionProvider::class, \Model\UserModel::class, \Core\Security\PasswordHelper::class]
];