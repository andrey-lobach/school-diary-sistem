<?php

namespace Middleware;

use Core\Request\Request;
use Core\Response\RedirectResponse;
use Core\Router\Route;
use Core\Security\MiddlewareInterface;
use Service\SecurityService;

/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 23.1.19
 * Time: 16.56
 */
class GuestMiddleware implements MiddlewareInterface
{

    /**
     * @var SecurityService
     */
    private $securityService;

    public function __construct(SecurityService $securityService)
    {

        $this->securityService = $securityService;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return \Core\Response\RedirectResponse|null
     */
    public function handle(Route $route, Request $request)
    {
        if (!$this->securityService->isAuthorized() && $request->getPath() !== '/login') {
            return new RedirectResponse('/login');
        }
        if ($this->securityService->isAuthorized() && ($request->getPath() === '/login' ||  $request->getPath() === '/')) {
            return new RedirectResponse('/my_profile');
        }
        return null;
    }
}