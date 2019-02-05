<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 14.19
 */

namespace Model;

use Core\DB\Connection;
use Enum\RolesEnum;

class ClassModel
{
    private $connection;

    /**
     * ClassModel constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $sql = 'SELECT * FROM classes ORDER BY title ASC';

        return $this->connection->fetchAll($sql);
    }

    /**
     * @param array $class
     */
    public function create(array $class)
    {
        $sql = 'INSERT INTO classes (title) VALUES (:title)';
        $this->connection->query($sql, $class);
    }

    /**
     * @param array $class
     * @param int   $id
     */
    public function edit(array $class, int $id)
    {
        $class['id'] = $id;
        $sql = 'UPDATE classes SET title=:title WHERE id=:id';
        $this->connection->query($sql, $class);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $sql = 'DELETE FROM classes WHERE id=:id';
        $this->connection->query($sql, ['id' => $id]);
    }

    /**
     * @param string   $title
     * @param int|null $id
     *
     * @return bool
     */
    public function checkTitle(string $title, int $id = null): bool
    {
        $params = ['title' => $title];
        if (null === $id) {
            $sql = 'SELECT id FROM classes WHERE title=:title';
        } else {
            $sql = 'SELECT id FROM classes WHERE title=:title AND id != :id';
            $params['id'] = $id;
        }

        return (bool) $this->connection->fetch($sql, $params, \PDO::FETCH_COLUMN);
    }

    /**
     * @param int $id
     *
     * @return null|array
     */
    public function getClass(int $id)
    {
        $sql = 'SELECT * FROM classes WHERE id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);

        return $user ?: null;
    }

    /**
     * @return array
     */
    public function getFullList(): array
    {
        $list = [];
        $classes = $this->getList();
        foreach ($classes as $class) {
            $sql = 'select user_id from enrollments where (class_id=:class_id) and (role=:role);';
            $students = $this->connection->fetchAll($sql, ['class_id' => $class['id'], 'role' => RolesEnum::STUDENT]);
            $teachers = $this->connection->fetchAll($sql, ['class_id' => $class['id'], 'role' => RolesEnum::TEACHER]);
            $list[$class['id']] = ['students' => $students, 'teachers' => $teachers];
        }

        return $list;
    }
}