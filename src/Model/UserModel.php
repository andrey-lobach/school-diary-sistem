<?php
/**
 * Created by PhpStorm.
 * UserModel: developer
 * Date: 1.11.18
 * Time: 17.53
 */

namespace Model;

use Core\DB\Connection;
use Core\Security\PasswordHelper;
use Core\Security\StringBuilder;

class UserModel
{

    private $connection;
    /**
     * @var PasswordHelper
     */
    private $passwordHelper;
    /**
     * @var StringBuilder
     */
    private $stringBuilder;

    public function __construct(Connection $connection, PasswordHelper $passwordHelper, StringBuilder $stringBuilder)
    {
        $this->connection = $connection;
        $this->passwordHelper = $passwordHelper;
        $this->stringBuilder = $stringBuilder;
    }

    public function getList(): array
    {
        $sql = 'select * from users';
        $users = $this->connection->fetchAll($sql);
        $users = array_map(function (array $user) {
            $user['roles'] = json_decode($user['roles']);
            return $user;
        }, $users);
        return $users;
    }

    public function create(array $user)
    {
        $user = $this->preparePassword($user);
        $user['roles'] = json_encode($user['roles']);
        $sql = 'insert into users (login, password, roles) values (:login, :password, :roles)';
        $this->connection->query($sql, $user);
    }

    public function edit(array $user, int $id)
    {
        $user = $this->preparePassword($user);
        $user['roles'] = json_encode($user['roles']);
        $user['id'] = $id;
        $sql = 'update users set login=:login, password=:password, roles=:roles where id=:id';
        $this->connection->query($sql, $user);
    }

    public function delete(int $id)
    {
        $sql = 'delete from users where id=:id';
        $this->connection->query($sql, ['id' => $id]);
    }

    public function checkLogin(string $login, int $id = null): bool
    {
        $params = ['login' => $login];
        if (null === $id) {
            $sql = 'select id from users where login=:login';
        } else {
            $sql = 'select id from users where login=:login and id != :id';
            $params['id'] = $id;
        }

        return (bool)$this->connection->fetch($sql, $params, \PDO::FETCH_COLUMN);
    }

    public function getUser(int $id)
    {
        $sql = 'select * from users where id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);
        if ($user) {
            $user['roles'] = json_decode($user['roles']);
        }
        return $user ?: null;
    }

    public function findByLogin(string $login)
    {
        $sql = 'select * from users where login = :login';
        $user = $this->connection->fetch($sql, ['login' => $login]);
        if ($user) {
            $user['roles'] = json_decode($user['roles']);
        }
        return $user ?: null;
    }

    private function preparePassword(array $user)
    {
        if ($user['plain_password']) {
            $password = $user['password'] ?? null;
            if ($password) {
                $salt = $this->passwordHelper->getSaltPart($password);
            } else {
                $salt = $this->stringBuilder->build(5);
            }
            $hash = $this->passwordHelper->getHash($user['plain_password'], $salt);
            $user['password'] = $this->passwordHelper->createToken($hash, $salt);
        }
        unset($user['plain_password']);
        return $user;
    }
}
