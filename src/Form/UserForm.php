<?php

namespace Form;

use Core\Request\Request;
use Model\UserModel;


class UserForm {


    private $data;
    private $violations = [];
    private $userModel;

    public function __construct(Request $request, UserModel $userModel)
    {
        $this->data = [
            'login' => $request->get('login'),
            'password' => $request->get('password'),
            'roles' => (array)$request->get('roles', []) // что-то не так
        ];
        print_r($this->data['roles']);
        $this->userModel = $userModel;
        $this->handleRequest();
    }

    public function handleRequest()
    {
        $logins = $this->userModel->getLogins();
        if (in_array($this->data['login'], $logins)) {
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