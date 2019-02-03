<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 17.23
 */
namespace Service;
use Core\HTTP\Session;
use Model\UserModel;

use Core\Security\PasswordHelper;

class SecurityService
{
    /**
     * @var Session
     */
    private $session;
    /**
     * @var UserModel
     */
    private $userModel;
    /**
     * @var PasswordHelper
     */
    private $passwordHelper;

    public function __construct(Session $session, UserModel $userModel, PasswordHelper $passwordHelper)
    {
        $this->session = $session;
        $this->userModel = $userModel;
        $this->passwordHelper = $passwordHelper;
    }

    public function isAuthorized(): bool
    {
        return $this->session->has('user');
    }

    public function logout()
    {
        $this->session->remove('user');
    }

    public function authorize(array $credentials): bool
    {
        if (!$this->isPasswordValid($credentials['login'], $credentials['password'])) {
            return false;
        }
        $user = $this->userModel->findByLogin($credentials['login']);
        $this->session->set('user', $user);
        return true;
    }

    public function userExist(string $login): bool
    {
        $result = (bool)$this->userModel->findByLogin($login);
        return (bool)$this->userModel->findByLogin($login);
    }

    public function isPasswordValid(string $login, string $password): bool
    {
        $user = $this->userModel->findByLogin($login);
        if (!$user){
            return false;
        }
        $salt = $this->passwordHelper->getSaltPart($user['password']);
        $hashPart = $this->passwordHelper->getHashPart($user['password']);
        $hash = $this->passwordHelper->getHash($password, $salt);
        return $hash === $hashPart;
    }

    public function getRole(): string
    {
        if ($this->isAuthorized()) {
            return $this->session->get('user')['role'];
        }
        return '';
    }
}