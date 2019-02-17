<?php

use Enum\RolesEnum;

return [
    '^/users'      => [RolesEnum::ADMIN],
    '^/subjects'   => [RolesEnum::ADMIN],
    '^/enrollment' => [RolesEnum::ADMIN, RolesEnum::TEACHER],
    '^/classes'    => [RolesEnum::ADMIN, RolesEnum::TEACHER],
    '^/logout$'    => [RolesEnum::ADMIN, RolesEnum::STUDENT, RolesEnum::TEACHER],
];