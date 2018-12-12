<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 19.12
 */

namespace Core\Security;


class StringBuilder
{
    public function build(int $length): string
    {
        $string = '';
        $stack = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
        $max = strlen($stack) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = rand(0, $max);
            $string .= $stack[$rand];
        }
        return $string;
    }
}