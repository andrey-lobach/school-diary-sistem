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
        $role = $this->securityService->getRole();
        if ($this->isAuthenticated($request->getPath(), $role) === false) {
            throw new UnauthorizedException();
        }
        return null;
    }

    private function isAuthenticated(string $path, string $role)
    {
        foreach ($this->routeSecurity as $pattern => $routeRoles){
            if (preg_match(sprintf('#%s#', preg_quote($pattern, '#')), $path)) {
                return in_array($role, $routeRoles, true);
            }
        }
        return null;
    }
}