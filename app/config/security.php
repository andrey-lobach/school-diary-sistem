<?php

use Enum\RolesEnum;

return [
    '^/users'      => [RolesEnum::ADMIN],
    '^/subjects'   => [RolesEnum::ADMIN],
    '^/enrollment' => [RolesEnum::ADMIN, RolesEnum::TEACHER],
    '^/classes'    => [RolesEnum::ADMIN],
    '^/logout$'    => [RolesEnum::ADMIN, RolesEnum::STUDENT, RolesEnum::TEACHER],
];