<?php

namespace Core\DB;

class Connection
{
    private $pdo;

    /**
     * Connection constructor.
     *
     * @param array $database
     */
    public function __construct(array $database)
    {
        $pdo = new \PDO(sprintf($database['dsn']), sprintf($database['user']), sprintf($database['password']));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    /**
     * @param string     $sql
     * @param array|null $params
     * @param int        $fetchStyle
     *
     * @return mixed
     */
    public function fetch(string $sql, array $params = null, $fetchStyle = \PDO::FETCH_ASSOC)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetch($fetchStyle);
    }

    /**
     * @param string     $sql
     * @param array|null $params
     * @param int        $fetchStyle
     *
     * @return array
     */
    public function fetchAll(string $sql, array $params = null, $fetchStyle = \PDO::FETCH_ASSOC): array
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll($fetchStyle);
    }

    /**
     * @param string     $sql
     * @param array|null $params
     */
    public function query(string $sql, array $params = null)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function quote($value): string
    {
        return $this->pdo->quote($value);
    }
}