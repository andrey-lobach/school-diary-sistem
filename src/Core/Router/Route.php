<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.55
 */

namespace Core\Router;

class Route
{

    private $path;

    private $controllerClass;

    private $method;

    private $rules;

    public function __construct(string $path,string $controllerClass,string $method, array $rules=[])
    {
        $this->path = $path;
        $this->controllerClass = $controllerClass;
        $this->method = $method;
        $this->rules = $rules;
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function match(string $path):bool
    {
        return $this->path === $path;
    }

    public function getPathValues (): array
    {
        //TODO implement
        //preg_match_all
        //#^/users/(\d+)/edit$#i
        return [];
    }
}