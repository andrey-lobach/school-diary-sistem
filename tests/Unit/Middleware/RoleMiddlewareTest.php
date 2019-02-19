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
        echo 'role: ', $role, ' url: ', $request->getPath(), PHP_EOL;//DELETE
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
        echo 'role: ', $role, ' url: ', $request->getPath(), PHP_EOL;//DELETE
        $this->handleRequest($routeSecurity, $role, $route, $request);
    }

    public function getDataForTestNotPermittedRequest(): array
    {
        $data = [];
        $routeSecurity = $this->getRouteSecurity();
        $route = new Route('', '', '');
        $adminAndTeacher = [RolesEnum::ADMIN, RolesEnum::TEACHER];
        foreach ($adminAndTeacher as $role){
            $data[] = [$routeSecurity, $role, $route, new Request('/my-class', '', [])];
        }
        $urls = [
            //'/users',
            //'/users/create',
            //'/users/1/edit',
            //'/users/1/delete',
            //'/classes',
            //'/my-class',
            //'/classes/create',
            //'/classes/1',
            //'/classes/1/edit',
            //'/classes/1/delete',
            //'/classes/1/add-student',
            //'/classes/1/add-teacher',
            //'/classes/1/join-class',
            //'/classes/1/leave-class',
            //'/enrollment/1/1/delete',
            //'/enrollment/1/1/create',
        ];

        foreach ($urls as $url) {
            foreach (RolesEnum::getAll() as $role) {
                $data[] = [$routeSecurity, $role, $route, new Request($url, '', [])];
            }
        }

        return $data;
    }

    public function getDataForTestPermittedRequest(): array
    {
        $data = [];
        $route = new Route('', '', '');
        $routeSecurity = $this->getRouteSecurity();
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
            '/enrollment/1/1/delete',
            '/enrollment/1/1/create',
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

        return $data;
    }

    /**
     * @return array
     */
    public function getRouteSecurity(): array
    {
        return [
            '^/users'      => [RolesEnum::ADMIN],
            '^/subjects'   => [RolesEnum::ADMIN],
            '^/enrollment' => [RolesEnum::ADMIN],
            '^/classes(?:|/\d+|/\d+/add-student|/\d+/leave-class|/\d+/join-class)$'   => [RolesEnum::ADMIN,RolesEnum::TEACHER],
            '^/classes/'    => [RolesEnum::ADMIN],
            '^/my-class$'  => [RolesEnum::STUDENT],
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
    public function handleRequest(array $routeSecurity, string $role, Route $route, Request $request): void
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
