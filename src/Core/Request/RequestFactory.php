<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 14.11.18
 * Time: 17.36
 */

namespace Core\Request;

class RequestFactory
{
    /**
     * @return Request
     */
    public static function createRequest(): Request
    {
        $request = new Request(
            self::getPath(),
            self::getMethod(),
            self::getRequest()
        );

        return $request;
    }

    /**
     * @return string
     */
    private static function getPath(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return array
     */
    private static function getRequest(): array
    {
        return $_REQUEST;
    }

    /**
     * @return string
     */
    private static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}