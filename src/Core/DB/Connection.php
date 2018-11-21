<?php

namespace Core\DB;

class Connection
{
    private $pdo;

    public function __construct(\PDO $pdo_)
    {
        $this->pdo = $pdo_;
    }

    public function fetchAll(string $sql) : array
    {
        return $this->pdo->query($sql)->fetchAll();
    }
}