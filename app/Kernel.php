<?php
require './../src/DB/Connection.php';
class Kernel
{
    private $config;
    private $connection;
    public function __construct()
    {
        $this->config = require __DIR__.'/config.php';
        $this->createConnection();
    }

    private function createConnection()
    {
        try {
            $pdo = new PDO(sprintf($this->config['dsn']), sprintf($this->config['user']), sprintf($this->config['password']));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = new Connection($pdo);
        } catch (PDOException $e){
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
    public function getModel()
    {

    }
}
