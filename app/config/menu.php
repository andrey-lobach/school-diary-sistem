<?php

use Enum\RolesEnum;

return [
    ['url'   => '/my_profile',
     'title' => 'My Profile',
     'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT],
    ],
    ['url' => '/users', 'title' => 'Users', 'roles' => [RolesEnum::ADMIN]],
    ['url' => '/enrollment', 'title' => 'Enrollments', 'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER]],
    ['url' => '/classes', 'title' => 'Classes', 'roles' => [RolesEnum::ADMIN]],
    ['url' => '/my_class', 'title' => 'My Class', 'roles' => [RolesEnum::STUDENT]],
    ['url' => '/logout', 'title' => 'Logout', 'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT]],
];