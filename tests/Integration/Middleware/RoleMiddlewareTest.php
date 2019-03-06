<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 19.2.19
 * Time: 17.27
 */

namespace Test\Integration\Middleware;

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
     * @param string  $role
     * @param Route   $route
     * @param Request $request
     */

    public function testNotPermittedRequest(string $role, Route $route, Request $request)
    {
        $this->handleRequest($role, $route, $request);
    }

    /**
     * @dataProvider getDataForTestPermittedRequest
     *
     * @doesNotPerformAssertions
     *
     * @param string $role
     * @param Route $route
     * @param Request $request
     * @throws \Core\HTTP\Exception\UnauthorizedException
     */
    public function testPermittedRequest(string $role, Route $route, Request $request)
    {
        $this->handleRequest($role, $route, $request);
    }

    public function getDataForTestNotPermittedRequest(): array
    {
        $data = [];
        $route = new Route('', '', '');
        $adminAndTeacher = [RolesEnum::ADMIN, RolesEnum::TEACHER];
        foreach ($adminAndTeacher as $role) {
            $data[] = [$role, $route, new Request('/my-class', '', [])];
        }
        $adminUrls = [
            '/classes/1/join-class',
            '/classes/1/leave-class',
        ];
        foreach ($adminUrls as $url) {
            $data[] = [RolesEnum::ADMIN, $route, new Request($url, '', [])];
        }
        $teacherUrls = [
            '/users',
            '/users/create',
            '/users/1/edit',
            '/users/1/delete',
            '/classes/1/add-teacher',
            '/classes/create',
            '/classes/1/edit',
            '/classes/1/delete',
        ];
        foreach ($teacherUrls as $url) {
            $data[] = [ RolesEnum::TEACHER, $route, new Request($url, '', [])];
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
            $data[] = [ RolesEnum::STUDENT, $route, new Request($url, '', [])];
        }

        return $data;
    }

    public function getDataForTestPermittedRequest(): array
    {
        $data = [];
        $route = new Route('', '', '');
        $adminUrls = [
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
        ];

        foreach ($adminUrls as $url) {
            $data[] = [RolesEnum::ADMIN, $route, new Request($url, '', [])];
        }
        $teacherUrls = [
            '/classes',
            '/classes/1',
            '/classes/1/add-student',
            '/classes/1/join-class',
            '/classes/1/leave-class',
        ];

        foreach ($teacherUrls as $url) {
            $data[] = [RolesEnum::TEACHER, $route, new Request($url, '', [])];
        }
        $data[] = [RolesEnum::STUDENT, $route, new Request('/my-class', '', [])];

        return $data;
    }

    /**
     * @return array
     */
    public function getRouteSecurity(): array
    {
        return require __DIR__.'/../../../app/config/security.php';
    }

    /**
     * @param string  $role
     * @param Route   $route
     * @param Request $request
     *
     * @throws \Core\HTTP\Exception\UnauthorizedException
     */
    public function handleRequest(string $role, Route $route, Request $request)
    {
        /** @var SecurityService|MockObject $security */
        $security = $this->createMock(SecurityService::class);
        $security
            ->method('getRole')
            ->willReturn($role);
        $middleware = new RoleMiddleware($this->getRouteSecurity(), $security);
        $middleware->handle($route, $request);
    }
}
