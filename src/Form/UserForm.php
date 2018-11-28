<?php

namespace Form;

use Core\Request\Request;


class UserForm {

    private $violations = [];
    private $data;

    public function __construct(array $user)
    {
        $this->data = $user;
    }

    public function handleRequest(Request $request)
    {

     //TODO проверка полей, в violations добавить ошибку (ключ => сообщение). для всех валидных значений поменять дефолтное значение
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
        //TODO проверить был ли обработан handlerequest
        return $this->violations;
    }

    public function isValid()
    {

        //TODO проверить был ли обработан handlerequest
        return count($this->violations) === 0;
    }


}