<?php

use Enum\RolesEnum;

return [
    '^/users' => [RolesEnum::ADMIN],
    '^/subjects' => [RolesEnum::ADMIN, RolesEnum::STUDENT, RolesEnum::TEACHER],
    '^/enrollment' => [RolesEnum::ADMIN],
    '^/students' => [RolesEnum::TEACHER],
    '^/teachers' => [RolesEnum::STUDENT],
    '^/logout$' => [RolesEnum::ADMIN, RolesEnum::STUDENT, RolesEnum::TEACHER],
];