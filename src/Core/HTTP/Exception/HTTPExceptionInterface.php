<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 26.2.19
 * Time: 16.48
 */

namespace Core\HTTP\Exception;

interface HTTPExceptionInterface
{

    public function getCode();

    public function getMessage();

}