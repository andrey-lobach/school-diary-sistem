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
        return $users;
    }

    public function create(array $user)
    {
        $user['roles'] = json_encode($user['roles']);
        $sql = 'insert into users (login, password, roles) values (:login, :password, :roles)';
        $this->connection->query($sql, $user);
    }

    public function delete (int $id)
    {
        $sql = sprintf('delete from users where id=%s', $id);
        $this->connection->query($sql);
    }
}
