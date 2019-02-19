<?php

use Enum\RolesEnum;

return [
    '^/users'                                                               => [RolesEnum::ADMIN],
    '^/subjects'                                                            => [RolesEnum::ADMIN],
    '^/enrollment'                                                          => [RolesEnum::ADMIN],
    '^/classes(?:|/\d+|/\d+/add-student|/\d+/leave-class|/\d+/join-class)$' => [RolesEnum::ADMIN, RolesEnum::TEACHER],
    '^/classes/'                                                            => [RolesEnum::ADMIN],
    '^/my-class$'                                                           => [RolesEnum::STUDENT],
];