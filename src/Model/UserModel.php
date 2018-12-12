<?php
/**
 * Created by PhpStorm.
 * UserModel: developer
 * Date: 1.11.18
 * Time: 17.53
 */

namespace Model;

use Core\DB\Connection;

class UserModel implements Model
{

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getList(): array
    {
        $sql = 'select * from users';
        $users = $this->connection->fetchAll($sql);
        $users = array_map(function (array $user) {
            $user['roles'] = json_decode($user['roles']);
            return $user;
        }, $users);
        return $users;
    }

    public function create(array $user)
    {
        $user['roles'] = json_encode($user['roles']);
        $sql = 'insert into users (login, password, roles) values (:login, :password, :roles)';
        $this->connection->query($sql, $user);
    }

    public function edit(array $user, int $id)
    {
        $user['roles'] = json_encode($user['roles']);
        $user['id'] = $id;
        $sql = 'update users set login=:login, password=:password, roles=:roles where id=:id';
        $this->connection->query($sql, $user);
    }

    public function delete(int $id)
    {
        $sql ='delete from users where id=:id';
        $this->connection->query($sql, ['id' => $id]);
    }

    public function checkLogin(string $login, int $id = null): bool
    {
        $params = ['login' => $login];
        if (null === $id) {
            $sql = 'select id from users where login=:login';
        } else {
            $sql = 'select id from users where login=:login and id != :id';
            $params['id'] = $id;
        }

        return (bool)$this->connection->fetch($sql, $params, \PDO::FETCH_COLUMN);
    }

    public function getUser(int $id)
    {
        $sql = 'select * from users where id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);
        if ($user) {
            $user['roles'] = json_decode($user['roles']);
        }
        return $user ?: null;
    }
}
