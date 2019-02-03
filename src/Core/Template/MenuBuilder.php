<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 30.1.19
 * Time: 18.15
 */

namespace Core\Template;

use Service\SecurityService;

class MenuBuilder
{
    /**
     * @var array
     */
    private $menu;

    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * MenuBuilder constructor.
     *
     * @param array           $menu
     * @param SecurityService $securityService
     */
    public function __construct(array $menu, SecurityService $securityService)
    {
        $this->menu = $menu;
        $this->securityService = $securityService;
    }

    /**
     * @return Menu
     */
    public function createMenu(): Menu
    {
        return new Menu($this->getItems());
    }

    /**
     * @return array
     */
    private function getItems():array
    {
        $menu = [];
        $role = $this->securityService->getRole(); // TODO foreach пройтись по $this->menu и выбрать те, которые для $role, вернуть массив menu
    }
}