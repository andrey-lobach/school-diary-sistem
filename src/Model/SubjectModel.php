<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 1.12
 */

namespace Model;

use Core\DB\Connection;

class SubjectModel implements Model
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getList(): array
    {
        $sql = 'select * from subjects';
        $subjects = $this->connection->fetchAll($sql);
        return $subjects;
    }

    public function create(array $subject)
    {
        $sql = 'insert into subjects (name) values (:name)';
        $this->connection->query($sql, $subject);
    }

    public function edit(array $subject, int $id)
    {
        $subject['id'] = $id;
        $sql = 'update subjects set name=:name where id=:id';
        $this->connection->query($sql, $subject);
    }

    public function delete(int $id)
    {
        $sql ='delete from subjects where id=:id';
        $this->connection->query($sql, ['id' => $id]);
    }

    public function checkName(string $name, int $id = null): bool
    {
        $params = ['name' => $name];
        if (null === $id) {
            $sql = 'select id from subjects where name=:name';
        } else {
            $sql = 'select id from subjects where name=:name and id != :id';
            $params['id'] = $id;
        }

        return (bool)$this->connection->fetch($sql, $params, \PDO::FETCH_COLUMN);
    }

    public function getSubject(int $id)
    {
        $sql = 'select * from subjects where id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);
        return $user ?: null;
    }
}