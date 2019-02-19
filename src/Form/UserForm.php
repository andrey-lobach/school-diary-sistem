<?php

namespace Form;

use Core\Request\Request;
use Enum\RolesEnum;
use Model\UserModel;
use Service\SecurityService;

class UserForm
{
    private $data;

    private $violations = [];

    private $userModel;

    /**
     * UserForm constructor.
     *
     * @param UserModel $userModel
     * @param array     $data
     */
    public function __construct(UserModel $userModel, array $data = [])
    {
        $this->userModel = $userModel;
        $this->data = $data;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $this->data['login'] = $request->get('login');
        $this->data['plain_password'] = $request->get('plain_password');
        $this->data['plain_password_confirm'] = $request->get('plain_password_confirm');
        $this->data['role'] = $request->get('role');
        $id = $this->data['id'] ?? null;
        $firstName = $this->data['first_name'] = $request->get('first_name');
        $lastName = $this->data['last_name'] = $request->get('last_name');
        if ($this->userModel->checkLogin($this->data['login'], $id)) {
            $this->violations['login'] = 'Such login exists';
        }
        if (!$id || $this->data['plain_password'] || $this->data['plain_password_confirm']) {
            if (strlen($this->data['plain_password']) < 5) {
                $this->violations['plain_password'] = 'Password is too short';
            } elseif (strlen($this->data['plain_password']) > 30) {
                $this->violations['plain_password'] = 'Password is too long';
            } elseif ($this->data['plain_password'] !== $this->data['plain_password_confirm']) {
                $this->violations['plain_password_confirm'] = 'Password confirm do not match password';
            }
        }
        $firstNameLen = strlen($firstName);
        $lastNameLen = strlen($lastName);
        if ($firstNameLen < 3 || $firstNameLen > 50) {
            $this->violations['first_name'] = 'The length of the first name must not be shorter than 3 and longer than 50 characters';
        }
        if ($lastNameLen < 3 || $lastNameLen > 50) {
            $this->violations['last_name'] = 'The length of the last name must not be shorter than 3 and longer than 50 characters';
        }
        if (!$this->data['role']) {
            $this->violations['role'] = 'At least, one role is required';
        } elseif (array_diff($this->data['role'], RolesEnum::getAll())) {
            $this->violations['role'] = 'Invalid roles';
        }

        if ($this->userModel->getUser($id)['role'] === RolesEnum::ADMIN &&
            $this->data['role'] !== RolesEnum::ADMIN &&
            (int)$this->userModel->getCountOfAdmins() === 1) {
            $this->violations['admin'] = 'At least must be 1 admin';
        }

    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = $this->data;
        unset($data['plain_password_confirm']);

        return $data;
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