<?php

namespace Core\DB;

class Connection
{
    private $pdo;

    public function __construct(array $database)
    {
        $pdo = new \PDO(sprintf($database['dsn']), sprintf($database['user']), sprintf($database['password']));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    public function fetch(string $sql, array $params = null, $fetchStyle=\PDO::FETCH_ASSOC)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement->fetch($fetchStyle);
    }

    public function fetchAll(string $sql, array $params = null, $fetchStyle=\PDO::FETCH_ASSOC) : array
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll($fetchStyle);
    }

    public function query(string $sql, array $params = null)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
    }
}