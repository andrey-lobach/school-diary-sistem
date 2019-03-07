<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 17.32
 */

namespace Core\Security;


class PasswordHelper
{
    /**
     * @param string $plainPassword
     * @param string $salt
     * @return string
     */
    public function getHash(string $plainPassword, string $salt): string
    {
        return md5($salt . '|' . $plainPassword);
    }

    /**
     * @param string $hash
     * @param string $salt
     * @return string
     */
    public function createToken(string $hash, string $salt): string
    {
        return sprintf('%s:%s', $salt, $hash);
    }

    /**
     * @param string $token
     * @return string
     */
    public function getHashPart(string $token): string
    {
        $parts = explode(':', $token, 2);
        return $parts[1];
    }

    /**
     * @param string $token
     * @return string
     */
    public function getSaltPart(string $token): string
    {
        $parts = explode(':', $token, 2);
        return $parts[0];
    }

}