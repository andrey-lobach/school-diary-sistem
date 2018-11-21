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

    public function fetchAll(string $sql, array $params = null) : array
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function query(string $sql, array $params = null)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
    }
}