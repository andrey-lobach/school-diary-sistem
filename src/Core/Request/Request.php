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

    private $attributes;

    private $path;

    private $method;

    private $request;

    public function __construct(string $path, string $method, array $request)
    {
        $this->request=$request;
        $this->path=$path;
        $this->method=$method;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getPath(): string
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

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $this->attributes)){
            return $this->attributes[$key];
        }
        return $this->request[$key] ?? $default;
    }

}