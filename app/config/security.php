<?php

use Enum\RolesEnum;

return [
    '^/users' => [RolesEnum::ADMIN],
    '^/subjects' => [RolesEnum::ADMIN, RolesEnum::STUDENT, RolesEnum::TEACHER],
    '^/enrollment' => [RolesEnum::ADMIN, RolesEnum::TEACHER],
    '^/logout$' => [RolesEnum::ADMIN, RolesEnum::STUDENT, RolesEnum::TEACHER],
];