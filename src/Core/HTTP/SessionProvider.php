<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 17.15
 */

namespace Core\HTTP;


use Core\InvokeInterface;

class SessionProvider implements InvokeInterface
{
    /**
     * @return Session
     * @throws \Exception
     */
    public function __invoke()
    {
        return Session::getInstance();
    }

}