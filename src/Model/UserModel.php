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

    public function getList(): array {
        $sql = 'select * from users';
        $users = $this->connection->fetchAll($sql);
        return $users;
    }
}
