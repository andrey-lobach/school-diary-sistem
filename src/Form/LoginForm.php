<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 18.07
 */

namespace Form;


use Core\Request\Request;
use Service\SecurityService;

class LoginForm
{
    private $data = [];
    private $violations = [];
    private $securityService;

    /**
     * LoginForm constructor.
     * @param SecurityService $securityService
     */
    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $this->data['login'] = $login = $request->get('login');
        $this->data['password'] = $password = $request->get('password');

        if ($login && $this->securityService->userExist($login)) {
            $isPasswordValid = $this->securityService->isPasswordValid($login, $password);
            if (!$isPasswordValid) {
                $this->violations['password'] = 'Invalid password';
            }
        } else {
            $this->violations['login'] = 'Invalid login';
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
    public function isValid()
    {
        return count($this->violations) === 0;
    }

}