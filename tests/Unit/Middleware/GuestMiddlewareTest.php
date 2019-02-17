<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 13.2.19
 * Time: 18.54
 */

namespace Test\Unit\Middleware;

use Core\Request\Request;
use Core\Response\RedirectResponse;
use Core\Router\Route;
use Middleware\GuestMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Service\SecurityService;

class GuestMiddlewareTest extends TestCase
{
    /**
     * @dataProvider getDataForRedirect
     *
     * @param bool    $isAuthorized
     * @param Route   $route
     * @param Request $request
     */
    public function testRedirect(bool $isAuthorized, Route $route, Request $request)
    {
        /** @var SecurityService|MockObject $security */
        $security = $this->createMock(SecurityService::class);
        $security
            ->method('isAuthorized')
            ->willReturn($isAuthorized);
        $middleware = new GuestMiddleware($security);
        $this->assertInstanceOf(RedirectResponse::class, $middleware->handle($route, $request));
        //$this->assertNull() TODO
    }

    public function getDataForRedirect(): array
    {
        $data = [];
        $route = new Route('', '', '');
        $request = new Request('/login', '', []);
        //$data[] = [false, $route, $request];
        $data[] = [true, $route, $request];

        return $data;
    }
}