<?php
return [
    \Controller\UserController::class => [\Model\UserModel::class],
    \Model\UserModel::class => [\Core\DB\Connection::class],
    \Core\DB\Connection::class => ['%database%']
];