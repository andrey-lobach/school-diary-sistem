<?php

use Core\HTTP\Exception\NotFoundException;
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

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->config = require __DIR__.'/config/config.php';
        $this->container = ServiceContainer::getInstance($this->config);
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Request $request
     *
     * @return Route
     * @throws NotFoundException
     */
    private function getRoute(Request $request): Route
    {
        require_once __DIR__.'/config/routes.php';
        $route = Router::findRoute($request);
        if ($route === null) {
            throw new NotFoundException('Route not found');
        }

        return $route;
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws NotFoundException
     */
    public function createResponse(Request $request): Response
    {
        $route = $this->getRoute($request);
        $params = $route->getPathValues($request->getPath());
        $request->setAttributes($params);
        /** @var Guardian $guardrian */
        $guardrian = $this->container->get(Guardian::class);
        if ($response = $guardrian->handle($route, $request)) {
            return $response;
        }
        $controller = $this->getController($route);

        return call_user_func([$controller, $route->getMethod()], $request);
    }

    /**
     * @return ServiceContainer
     */
    public function getContainer(): ServiceContainer
    {
        return $this->container;
    }

    /**
     * @param Route $route
     *
     * @return mixed
     */
    private function getController(Route $route)
    {
        return $this->container->get($route->getControllerClass());
    }
}
