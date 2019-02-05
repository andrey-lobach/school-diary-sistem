<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 25.1.19
 * Time: 12.28
 */

namespace Model;

use Core\DB\Connection;
use Enum\RolesEnum;

class EnrollmentModel
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * EnrollmentModel constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int    $classId
     * @param int    $userId
     * @param string $role
     */
    public function create(int $userId, int $classId, string $role)
    {
        $sql = 'INSERT INTO enrollments (class_id, user_id, role) VALUES (:class_id, :user_id, :role);';
        $this->connection->query($sql, ['class_id' => $classId, 'user_id' => $userId, 'role' => $role]);
    }

    /**
     * @param int $userId
     * @param int $classId
     */
    public function delete(int $userId, int $classId)
    {
        $sql = 'DELETE FROM enrollments WHERE user_id = :user_id AND class_id = :class_id';
        $this->connection->query($sql, ['user_id' => $userId, 'class_id' => $classId]);
    }

    /**
     * @param array $teachers
     * @param int   $countOfClasses
     *
     * @return array
     */
    public function getAvailableTeachers(array $teachers, int $countOfClasses): array
    {
        foreach ($teachers as $key => $teacher) {
            $sql = 'SELECT * FROM enrollments WHERE user_id = :user_id';
            $count = count($this->connection->fetchAll($sql, ['user_id' => $teacher['id']]));
            if ($countOfClasses === $count) {
                unset($teachers[$key]);
            }
        }

        return $teachers;
    }

    /**
     * @param int $id
     *
     * @return null|array
     */
    public function getEnrollment(int $id)
    {
        $sql = 'SELECT * FROM enrollments WHERE id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);

        return $user ?: null;
    }

    public function isEnrollment(int $userId, int $classId): bool
    {
        $sql = 'SELECT id FROM enrollments WHERE (user_id = :user_id AND class_id = :class_id) LIMIT 1;';
        $user = $this->connection->fetch($sql, ['user_id' => $userId, 'class_id' => $classId], \PDO::FETCH_COLUMN);

        return (bool) $user;
    }

    /**
     * @param array $userIds
     * @param int   $classId
     */
    public function addStudents(array $userIds, int $classId)
    {
        foreach ($userIds as $userId) {
            $this->create($userId, $classId, RolesEnum::STUDENT);
        }
    }

    /**
     * @param array $userIds
     * @param array $classIds
     */
    public function addTeachers(array $userIds, array $classIds)
    {
        foreach ($userIds as $userId) {
            foreach ($classIds as $classId) {
                $this->create($userId, $classId, RolesEnum::TEACHER);
            }
        }
    }
}