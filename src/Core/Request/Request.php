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
    private $path;

    private $request;

    public function __construct(string $path, array $request)
    {
        $this->request=$request;
        $this->path=$path;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getPath()
    {
        return $this->path;
    }

}