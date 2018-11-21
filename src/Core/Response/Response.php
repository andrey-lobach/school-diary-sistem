<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 14.11.18
 * Time: 17.58
 */

namespace Core\Response;


class Response
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function send()
    {
        echo $this->content;
    }
}