<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 14.19
 */

namespace Model;

use Core\DB\Connection;

class ClassModel
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getList(): array
    {
        $sql = 'select * from classes';
        $classes = $this->connection->fetchAll($sql);
        return $classes;
    }

    public function create(array $class)
    {
        $sql = 'insert into classes (title) values (:title)';
        $this->connection->query($sql, $class);
    }

    public function edit(array $class, int $id)
    {
        $class['id'] = $id;
        $sql = 'update classes set title=:title where id=:id';
        $this->connection->query($sql, $class);
    }

    public function delete(int $id)
    {
        $sql = 'delete from classes where id=:id';
        $this->connection->query($sql, ['id' => $id]);
    }

    public function checkTitle(string $title, int $id = null): bool
    {
        $params = ['title' => $title];
        if (null === $id) {
            $sql = 'select id from classes where title=:title';
        } else {
            $sql = 'select id from classes where title=:title and id != :id';
            $params['id'] = $id;
        }

        return (bool)$this->connection->fetch($sql, $params, \PDO::FETCH_COLUMN);
    }

    public function getClass(int $id)
    {
        $sql = 'select * from classes where id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);
        return $user ?: null;
    }
}