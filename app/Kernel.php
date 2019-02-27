<?php

use Core\HTTP\Exception\RequestException;
use Core\Request\Request;
use Core\Response\Response;
use Core\Router\Route;
use Core\Router\Router;
use Core\Security\Guardian;
use Core\ServiceContainer;

class Kernel
{
    private $config;
    private $connection;
    public function __construct()
    {
        $this->config = require __DIR__.'/config/config.php';
        $this->container = ServiceContainer::getInstance($this->config);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Request $request
     *
     * @return Route
     */
    private function getRoute(Request $request): Route
    {
        require_once __DIR__.'/config/routes.php';
        $route = Router::findRoute($request);
        if ($route === null) {
            throw new RequestException('Route not found', 404);
        }

        return $route;
    }

    public function createResponse(Request $request): Response
    {
        $route = $this->getRoute($request);
        /** @var Guardian $guardrian */
        $guardrian = $this->container->get(Guardian::class);
        if ($response = $guardrian->handle($route, $request)) {
            return $response;
        }
        $controller = $this->getController($route);
        $params = $route->getPathValues($request->getPath());
        $request->setAttributes($params);

        return call_user_func([$controller, $route->getMethod()], $request);
    }

    private function getController(Route $route)
    {
        return $this->container->get($route->getControllerClass());
    }
}
