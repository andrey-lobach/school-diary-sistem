<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 27.2.19
 * Time: 13.25
 */

namespace Test\Unit;

use Core\Template\MenuBuilder;
use Enum\RolesEnum;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Service\SecurityService;

class MenuBuilderTest extends TestCase
{
    /**
     * @param array  $menu
     * @param string $role
     *
     * @return mixed
     */
    public function getItems(array $menu, string $role)
    {
        /** @var SecurityService|MockObject $security */
        $security = $this->createMock(SecurityService::class);
        $security
            ->method('getRole')
            ->willReturn($role);
        $menuBuilder = new MenuBuilder($menu, $security);

        /* $items = (function(){
            return $this->getItems();
        })->call($menuBuilder); */

        return $this->invokeMethod($menuBuilder, 'getItems');
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of\ parameters to pass into method.
     *
     * @return mixed Method return.
     * @throws \ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     **@dataProvider getDataForTestGetItems
     * @param array  $expected
     * @param array  $menu
     * @param string $role
     */
    public function testGetItems(array $expected, array $menu, string $role)
    {
        $this->assertEquals($expected, $this->getItems($menu, $role));
    }

    /**
     * @return array
     */
    public function getDataForTestGetItems(): array
    {

        $menu = $this->getMenu();
        $data = [];
        $data[] = [
            [
                ['url' => '/my-profile', 'title' => 'My Profile'],
                ['url' => '/my-class', 'title' => 'My Class'],
                ['url' => '/logout', 'title' => 'Logout'],
            ],
            $menu,
            RolesEnum::STUDENT,
        ];
        $data[] = [
            [
                ['url' => '/my-profile', 'title' => 'My Profile'],
                ['url' => '/classes', 'title' => 'Classes'],
                ['url' => '/logout', 'title' => 'Logout'],

            ],
            $menu,
            RolesEnum::TEACHER,
        ];
        $data[] = [
            [
                ['url' => '/my-profile', 'title' => 'My Profile'],
                ['url' => '/users', 'title' => 'Users'],
                ['url' => '/classes', 'title' => 'Classes'],
                ['url' => '/logout', 'title' => 'Logout'],
            ],
            $menu,
            RolesEnum::ADMIN,
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function getMenu(): array
    {
        return [
            [
                'url'   => '/my-profile',
                'title' => 'My Profile',
                'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT],
            ],
            ['url' => '/users', 'title' => 'Users', 'roles' => [RolesEnum::ADMIN]],
            ['url' => '/classes', 'title' => 'Classes', 'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER]],
            ['url' => '/my-class', 'title' => 'My Class', 'roles' => [RolesEnum::STUDENT]],
            [
                'url'   => '/logout',
                'title' => 'Logout',
                'roles' => [RolesEnum::ADMIN, RolesEnum::TEACHER, RolesEnum::STUDENT],
            ],
        ];
    }
}
