<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 23.1.19
 * Time: 16.25
 */

namespace Core\Security;


use Core\Request\Request;
use Core\Response\RedirectResponse;
use Core\Router\Route;

class Guardian implements MiddlewareInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $sentinels;

    public function __construct(...$sentinels)
    {
        $this->sentinels = $sentinels;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function handle(Route $route, Request $request)
    {
        foreach ($this->sentinels as $sentinel) {
            if ($response = $sentinel->handle($route, $request)) {
                return $response;
            }
        }

        return null;
    }
}