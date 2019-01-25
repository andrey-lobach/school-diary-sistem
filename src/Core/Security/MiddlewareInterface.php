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

interface MiddlewareInterface
{
    /**
     * @param Route $route
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function handle(Route $route, Request $request);
}