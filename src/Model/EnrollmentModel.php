<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 16.33
 */

namespace Model;
use Core\DB\Connection;

class EnrollmentModel
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function create(array $enrollment)
    {
        $sql = 'insert into enrollments (class_id, user_id, role) values (:class_id, :user_id, :role)';
        $this->connection->query($sql, $enrollment);
    }
}