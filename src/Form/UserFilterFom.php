<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 2.3.19
 * Time: 18.52
 */

namespace Form;

use Core\Request\Request;
use Model\UserModel;

class UserFilterFom
{
    private $data;

    private $violations = [];

    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * UserFilterFom constructor.
     *
     * @param UserModel $userModel
     */
    public function __construct(UserModel $userModel)
    {
        $this->data = ['page' => ['limit' => 5, 'offset' => 0, 'current_page' => 1], 'order_dir' => 'asc', 'order_by' => 'login', 'filter' => ['name' => null, 'role' => null]];
        $this->userModel = $userModel;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $this->data['page'] = array_merge($this->data['page'], (array)$request->get('page', []));
        $this->data['filter'] = array_merge($this->data['filter'], $request->get('filter', []));
        $this->data['order_dir'] = $request->get('order_dir');
        $this->data['order_by'] = $request->get('order_by');

    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return count($this->violations) === 0;
    }
}