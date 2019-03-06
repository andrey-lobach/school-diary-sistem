<?php

use Enum\RolesEnum;

return [
    '^/users'      => [RolesEnum::ADMIN],
    '^/classes(?:|/\d+|/\d+/add-student)$'   => [RolesEnum::ADMIN, RolesEnum::TEACHER],
    '^/classes(?:|/\d+/leave-class|/\d+/join-class)$'   => [RolesEnum::TEACHER],
    '^/classes(?:|/\d+/add-teacher|/create)$'   => [RolesEnum::ADMIN],
    '^/my-class$'  => [RolesEnum::STUDENT],
];

