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
     * @param array     $data
     */
    public function __construct(UserModel $userModel, array $data = [])
    {
        $this->data = $data;
        $this->userModel = $userModel;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {

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