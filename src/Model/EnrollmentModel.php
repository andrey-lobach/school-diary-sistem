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
     * @param array $params
     */
    public function create(array $params)
    {
        $sql = 'insert into enrollments (class_id, user_id, role) values (:class_id, :user_id, :role);';
        $this->connection->query($sql, $params);
    }

    /**
     * @param int $userId
     */
    public function delete(int $userId)
    {
        $sql = 'delete from enrollments where user_id = :user_id';
        $this->connection->query($sql, ['user_id' => $userId]);
    }

    /**
     * @param array $users
     * @return array
     */
    public function getAvailableUsers(array $users): array
    {
        $sql = 'select user_id from enrollments';
        $list_ = $this->connection->fetchAll($sql);
        $list = [];
        foreach($list_ as $item){
            array_push($list, $item['user_id']);
        }
        foreach ($users as $key => $user) {
            if (in_array($user['id'], $list)) {
                unset($users[$key]);
            }
        }
        return $users;
    }

    /**
     * @param int $id
     * @return null|array
     */
    public function getEnrollment(int $id)
    {
        $sql = 'select * from enrollments where id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);
        return $user ?: null;
    }
}