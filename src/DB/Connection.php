<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 1.11.18
 * Time: 17.53
 */


class Connection
{
    private $pdo;

    public function __construct(PDO $pdo_)
    {
        $this->pdo = $pdo_;
    }

    public function fetchAll(string $sql)
    {
        return $this->pdo->query($sql)->fetchAll();
    }
}