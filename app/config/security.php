<?php

use Enum\RolesEnum;

return [
    '^/my-profile$' =>[RolesEnum::getAll()],
    '^/users'      => [RolesEnum::ADMIN],

];

