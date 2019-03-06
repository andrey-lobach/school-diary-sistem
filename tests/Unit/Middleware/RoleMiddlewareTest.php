<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 19.2.19
 * Time: 17.27
 */

namespace Test\Unit\Middleware;

use Core\Request\Request;
use Core\Router\Route;
use Enum\RolesEnum;
use Middleware\RoleMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Service\SecurityService;

class RoleMiddlewareTest extends TestCase
{
    /**
     * @dataProvider getDataForTestNotPermittedRequest
     * @expectedException \Core\HTTP\Exception\UnauthorizedException
     *
     * @param array   $routeSecurity
     * @param string  $role
     * @param Route   $route
     * @param Request $request
     */

    public function testNotPermittedRequest(array $routeSecurity, string $role, Route $route, Request $request)
    {
        $this->handleRequest($routeSecurity, $role, $route, $request);
    }

    /**
     * @dataProvider getDataForTestPermittedRequest
     *
     * @doesNotPerformAssertions
     *
     * @param array   $routeSecurity
     * @param string  $role
     * @param Route   $route
     * @param Request $request
     */
    public function testPermittedRequest(array $routeSecurity, string $role, Route $route, Request $request)
    {
        $this->handleRequest($routeSecurity, $role, $route, $request);
    }

    public function getDataForTestNotPermittedRequest(): array
    {
        $data = [];
        $routeSecurity = $this->getRouteSecurity();
        $route = new Route('', '', '');
        $adminUrls = [
            '/classes',
            '/classes/1',
            '/classes/1/add-student',
            '/classes/1/join-class',
            '/classes/1/leave-class',
            '/my-class'
        ];
        foreach ($adminUrls as $url) {
            $data[] = [$routeSecurity, RolesEnum::ADMIN, $route, new Request($url, '', [])];
        }
        $teacherUrls = [
            '/users',
            '/users/create',
            '/users/1/edit',
            '/users/1/delete',
            '/my-class'
        ];
        foreach ($teacherUrls as $url) {
            $data[] = [$routeSecurity, RolesEnum::TEACHER, $route, new Request($url, '', [])];
        }
        $studentUrls = [
            '/users',
            '/users/create',
            '/users/1/edit',
            '/users/1/delete',
            '/classes',
            '/classes/create',
            '/classes/1',
            '/classes/1/edit',
            '/classes/1/delete',
            '/classes/1/add-student',
            '/classes/1/add-teacher',
            '/classes/1/join-class',
            '/classes/1/leave-class',
        ];
        foreach ($studentUrls as $url) {
            $data[] = [$routeSecurity, RolesEnum::STUDENT, $route, new Request($url, '', [])];
        }

        return $data;
    }

    public function getDataForTestPermittedRequest(): array
    {
        $data = [];
        $route = new Route('', '', '');
        $routeSecurity = $this->getRouteSecurity();
        $urls = [
            '/my-profile',
            '/logout',
        ];
        foreach ($urls as $url) {
            foreach (RolesEnum::getAll() as $role) {
                $data[] = [$routeSecurity, $role, $route, new Request($url, '', [])];
            }
        }
        $adminUrls = [
            '/users',
            '/users/create',
            '/users/1/edit',
            '/users/1/delete',
        ];

        foreach ($adminUrls as $url) {
            $data[] = [$routeSecurity, RolesEnum::ADMIN, $route, new Request($url, '', [])];
        }
        $teacherUrls = [
            '/classes',
            '/classes/1',
            '/classes/1/add-student',
            '/classes/1/join-class',
            '/classes/1/leave-class',
        ];

        foreach ($teacherUrls as $url) {
            $data[] = [$routeSecurity, RolesEnum::TEACHER, $route, new Request($url, '', [])];
        }
        $data[] = [$routeSecurity, RolesEnum::STUDENT, $route, new Request('/my-class', '', [])];

        return $data;
    }

    /**
     * @return array
     */
    public function getRouteSecurity(): array
    {
        return [
            '^/logout$'      => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT],
            '^/my-profile$' => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT],
            '^/users'       => [RolesEnum::ADMIN],
            '^/classes'     => [RolesEnum::TEACHER],
            '^/my-class$'   => [RolesEnum::STUDENT],
        ];
    }

    /**
     * @param array   $routeSecurity
     * @param string  $role
     * @param Route   $route
     * @param Request $request
     *
     * @throws \Core\HTTP\Exception\UnauthorizedException
     */
    public function handleRequest(array $routeSecurity, string $role, Route $route, Request $request)
    {
        /** @var SecurityService|MockObject $security */
        $security = $this->createMock(SecurityService::class);
        $security
            ->method('getRole')
            ->willReturn($role);
        $middleware = new RoleMiddleware($routeSecurity, $security);
        $middleware->handle($route, $request);
    }
}
