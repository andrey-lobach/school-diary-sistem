<?php

use Enum\RolesEnum;

return [
    ['url'   => '/my-profile',
     'title' => 'My Profile',
     'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT],
    ],
    ['url' => '/users', 'title' => 'Users', 'roles' => [RolesEnum::ADMIN]],
    ['url' => '/classes', 'title' => 'Classes', 'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER]],
    ['url' => '/my-class', 'title' => 'My Class', 'roles' => [RolesEnum::STUDENT]],
    ['url' => '/logout', 'title' => 'Logout', 'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT]],
];