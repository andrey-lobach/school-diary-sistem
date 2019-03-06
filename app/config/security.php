<?php

use Enum\RolesEnum;

return [
    '^/users'      => [RolesEnum::ADMIN],
    '^/classes(?:|/\d+|/\d+/add-student)$'   => [RolesEnum::ADMIN, RolesEnum::TEACHER],
    '^/classes(?:|/\d+/add-teacher|/create|/\d+/delete|/\d+/edit)$'   => [RolesEnum::ADMIN],
    '^/classes(?:|/\d+/leave-class|/\d+/join-class)$'   => [RolesEnum::TEACHER],
    '^/my-class$'  => [RolesEnum::STUDENT],
];

