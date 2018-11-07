<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 1.11.18
 * Time: 17.53
 */
namespace Model;

use DB\Connection;

class User implements Model
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * User constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getList(): array {
        $sql = '';
        $options = [];
        $users = $this->connection->fetchAll($sql, $options);

        return $users;
    }
}
