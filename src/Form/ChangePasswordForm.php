<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 17.2.19
 * Time: 23.25
 */

namespace Form;

use Core\Request\Request;
use Core\Security\PasswordHelper;
use Core\Security\StringBuilder;
use Service\SecurityService;

/**
 * Class ChangePasswordForm
 * @package Form
 */
class ChangePasswordForm
{
    private $data = [];

    private $violations = [];

    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * ChangePasswordForm constructor.
     *
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
        $currentPassword = $this->data['currentPassword'] = $request->get('currentPassword');
        $newPassword = $this->data['newPassword'] = $request->get('newPassword');
        $passwordConfirm = $this->data['passwordConfirm'] = $request->get('passwordConfirm');
        if (!$this->securityService->isPasswordValid($this->securityService->getUser()['login'], $currentPassword)) {
            $this->violations['currentPassword'] = 'Current password does not match';
        }
        if ($newPassword !== $passwordConfirm) {
            $this->violations['passwordConfirm'] = 'New password does not match';
        }
        if (strlen($newPassword) < 5) {
            $this->violations['password'] = 'Password is too short';
        }
        if (strlen($newPassword) > 30) {
            $this->violations['password'] = 'Password is too long';
        }
        if ($this->securityService->isPasswordValid($this->securityService->getUser()['login'], $newPassword)) {
            $this->violations['newPassword'] = 'New and old passwords match';
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