<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 21.11.18
 * Time: 17.36
 */

namespace Enum;


final class RolesEnum
{
    const ADMIN = 'admin';

    const STUDENT = 'student';

    const TEACHER = 'teacher';

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return [self::ADMIN, self::STUDENT, self::TEACHER];
    }
}
