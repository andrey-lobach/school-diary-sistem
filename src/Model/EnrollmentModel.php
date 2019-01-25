<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 25.1.19
 * Time: 12.28
 */

namespace Model;


use Core\DB\Connection;

class EnrollmentModel
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * EnrollmentModel constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $classId
     * @param string $role
     * @return array
     */
    public function listOfClass(int $classId, string $role): array
    {
        $sql = 'select user_id from enrollments where (class_id=:class_id) and (role=:role);';
        return $this->connection->fetchAll($sql, ['class_id' => $classId, 'role' => $role]);
    }

    /**
     * @return array
     */
    public function getAvailableUsers(): array
    {

        return [];
    }

}