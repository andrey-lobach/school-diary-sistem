<?php

use Core\DB\Connection;
use Core\Request\Request;
use Core\Response\Response;
use Core\Router\Route;
use Core\Router\Router;

class Kernel
{
    private $config;
    private $connection;

    public function __construct()
    {
        $this->config = require __DIR__ . '/config/config.php';
        $this->createConnection();
    }

    private function createConnection()
    {
        try {
            $pdo = new PDO(sprintf($this->config['dsn']), sprintf($this->config['user']), sprintf($this->config['password']));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = new Connection($pdo);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function getRoute(Request $request): Route
    {
        require_once __DIR__.'/config/routes.php';
        $route = Router::findRoute($request);
        if ($route === null) {
            echo 'error';
        }
        return $route;
    }

    public function createResponse(Request $request):Response
    {
        $route = $this->getRoute($request);
        $controller = $this->getController($route);
        return call_user_func([$controller, $route->getMethod()], $request);
    }

    private function getController(Route $route)
    {
        $class = $route->getControllerClass();
        $model = new \Model\UserModel($this->connection);
        return new $class($model);
    }
}
