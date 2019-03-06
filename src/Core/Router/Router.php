<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.55
 */

namespace Core\Router;
use Core\Request\Request;

class Router
{
    /**
     * @var Route[]
     */
    private static $routes = [];

    /**
     * @param Request $request
     *
     * @return Route|null
     */
    public static function findRoute(Request $request)
    {
        foreach (self::$routes as $route) {
            if ($route->match($request->getPath())) {
                return $route;
            }
        }
        return null;
    }

    /**
     * @param string $pattern
     * @param string $controllerClass
     * @param string $method
     * @param array  $rules
     */
    public static function add(string $pattern, string $controllerClass, string $method, array $rules = [])
    {
        self::$routes[] = new Route($pattern, $controllerClass, $method, $rules);
    }
}