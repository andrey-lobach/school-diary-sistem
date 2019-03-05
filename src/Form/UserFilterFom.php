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
     * @param array $data
     */
    public function __construct(UserModel $userModel)
    {
        $this->data = ['page' => ['limit' => 5, 'offset' => 0], 'order_dir' => 'ASC', 'order_by' => 'login', 'filter' => ['name' => null, 'role' => null]];
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
        if (!$this->data['page']['limit']) {
            $this->violations['page']['limit'] = 'No per page value';
        } elseif ($this->data['page']['limit'] > 200) {
            $this->data['page']['limit'] = 200;
        }
        if ($this->data['filter']['name'] === '') {
            $this->data['filter']['name'] = null;
        }
        if ($this->data['order_by'] === '') {
            $this->data['order_by'] = null;
        }
        if ($this->data['filter']['role'] === '') {
            $this->data['filter']['role'] = null;
        }
        if ($this->data['page']['offset'] === '') {
            $this->data['page']['offset'] = 0;
        } else {
            $this->data['current_page'] = $this->data['page']['offset'];
            $this->data['page']['offset'] = ($this->data['page']['offset'] - 1) * $this->data['page']['limit'];
        }


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