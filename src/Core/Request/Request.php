<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 14.11.18
 * Time: 17.36
 */

namespace Core\Request;


class Request
{
    const POST = 'POST';

    const GET = 'GET';

    private $path;

    private $method;

    private $request;

    public function __construct(string $path, string $method, array $request)
    {
        $this->request=$request;
        $this->path=$path;
        $this->method=$method;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function get(string $key, $default = null)
    {
        return $this->request[$key] ?? $default;
    }

}