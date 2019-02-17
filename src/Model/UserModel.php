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
use Enum\RolesEnum;

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

    /**
     * UserModel constructor.
     *
     * @param Connection     $connection
     * @param PasswordHelper $passwordHelper
     * @param StringBuilder  $stringBuilder
     */
    public function __construct(Connection $connection, PasswordHelper $passwordHelper, StringBuilder $stringBuilder)
    {
        $this->connection = $connection;
        $this->passwordHelper = $passwordHelper;
        $this->stringBuilder = $stringBuilder;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $sql = 'SELECT * FROM users ORDER BY login ASC';

        return $this->connection->fetchAll($sql);
    }

    /**
     * @param array $user
     */
    public function create(array $user)
    {
        $user = $this->preparePassword($user);
        $sql = 'INSERT INTO users (login, password, first_name, last_name, role) VALUES (:login, :password, :first_name, :last_name, :role);';
        $this->connection->query($sql, $user);
    }

    /**
     * @param array $user
     * @param int   $id
     */
    public function edit(array $user, int $id)
    {
        $user = $this->preparePassword($user);
        $user['id'] = $id;
        $sql = 'UPDATE users SET login=:login, password=:password, first_name=:first_name, last_name=:last_name, role=:role WHERE id=:id';
        $this->connection->query($sql, $user);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $sql = 'DELETE FROM users WHERE id=:id';
        $this->connection->query($sql, ['id' => $id]);
    }

    /**
     * @param string   $login
     * @param int|null $id
     *
     * @return bool
     */
    public function checkLogin(string $login, int $id = null): bool
    {
        $params = ['login' => $login];
        if (null === $id) {
            $sql = 'SELECT id FROM users WHERE login=:login';
        } else {
            $sql = 'SELECT id FROM users WHERE login=:login AND id != :id';
            $params['id'] = $id;
        }

        return (bool) $this->connection->fetch($sql, $params, \PDO::FETCH_COLUMN);
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function getUser(int $id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $user = $this->connection->fetch($sql, ['id' => $id]);

        return $user ?: null;
    }

    /**
     * @param string $login
     *
     * @return array|null
     */
    public function findByLogin(string $login)
    {
        $sql = 'SELECT * FROM users WHERE login = :login';
        $user = $this->connection->fetch($sql, ['login' => $login]);

        return $user ?: null;
    }

    /**
     * @param array $user
     *
     * @return array
     */
    private function preparePassword(array $user): array
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

    /**
     * @return array
     */
    public function getStudentsWithoutEnrollment(): array
    {
        $sql = 'SELECT users.id, first_name, last_name
                FROM users 
                LEFT JOIN enrollments ON (users.id = enrollments.user_id) 
                WHERE (enrollments.id IS NULL AND users.role =:role) 
                ORDER BY login ASC';

        return $this->connection->fetchAll($sql, ['role' => RolesEnum::STUDENT]);
    }

    /**
     * @param int $classId
     *
     * @return array
     */
    public function getAvailableTeachers(int $classId): array
    {
       $sql = 'select * from users where role=:role';
       $teachers = $this->connection->fetchAll($sql, ['role' => RolesEnum::TEACHER]);
       foreach ($teachers as $key => $teacher){
           $sql = 'select id from enrollments where user_id =:user_id and class_id =:class_id';
           if ($this->connection->fetch($sql, ['user_id' => $teacher['id'], 'class_id' => $classId])){
               unset($teachers[$key]);
           }
       }
       return $teachers;
    }
}