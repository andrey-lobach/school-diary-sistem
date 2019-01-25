<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 23.1.19
 * Time: 17.05
 */

namespace Middleware;


use Core\HTTP\Exception\UnauthorizedException;
use Core\Request\Request;
use Core\Response\RedirectResponse;
use Core\Router\Route;
use Core\Security\MiddlewareInterface;
use Service\SecurityService;

class RoleMiddleware implements MiddlewareInterface
{


    /**
     * @var array
     */
    private $routeSecurity;
    /**
     * @var SecurityService
     */
    private $securityService;

    public function __construct(array $routeSecurity, SecurityService $securityService)
    {
        $this->routeSecurity = $routeSecurity;
        $this->securityService = $securityService;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return RedirectResponse|null
     * @throws UnauthorizedException
     */
    public function handle(Route $route, Request $request)
    {
        $roles = $this->securityService->getRoles();
        if ($this->isAuthenticated($request->getPath(), $roles) === false) {
            throw new UnauthorizedException();
        }
        return null;
    }

    public function isAuthenticated(string $path, array $roles)
    {
        foreach ($this->routeSecurity as $pattern => $routeRoles){
            if (preg_match(sprintf('#%s#', $pattern), $path)) {
                return count(array_intersect($roles, $routeRoles)) > 0;
            }
        }
        return null;
    }
}