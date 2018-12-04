<?php

namespace Form;

use Core\Request\Request;
use Model\UserModel;


class UserForm
{

    private $data;
    private $violations = [];
    private $userModel;

    public function __construct(UserModel $userModel, array $data = [])
    {
        $this->userModel = $userModel;
        $this->data['login'] = $data['login'];
        $this->data['password'] = $data['password'];
        $this->data['roles'] = $data['roles'];
    }

    public function handleRequest(Request $request)
    {
        $this->data = [
            'login' => $request->get('login'),
            'password' => $request->get('password'),
            'roles' => (array)$request->get('roles', []) // что-то не так
        ];
        if ($this->userModel->checkLogin($this->data['login'])) {
            $this->violations['login_error: '] = 'such login exists';
        }
        if (strlen($this->data['password']) < 5) {
            $this->violations['password_error: '] = 'password is too short';
        }
        if (strlen($this->data['password']) > 30) {
            $this->violations['password_error: '] = 'password is too long';
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



    public function isValid()
    {
        return count($this->violations) === 0;
    }


}