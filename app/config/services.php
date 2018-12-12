<?php
return [
    \Core\DB\Connection::class => ['%database%'],
    \Controller\UserController::class => [\Model\UserModel::class],
    \Model\UserModel::class => [\Core\DB\Connection::class],
    \Controller\SubjectController::class => [\Model\SubjectModel::class],
    \Model\SubjectModel::class=>[\Core\DB\Connection::class],
    \Controller\ClassController::class => [\Model\ClassModel::class],
    \Model\ClassModel::class=>[\Core\DB\Connection::class]
];