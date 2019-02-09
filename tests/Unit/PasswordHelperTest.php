<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 6.2.19
 * Time: 18.55
 */

namespace Test\Unit;

use Core\Security\PasswordHelper;
use PHPUnit\Framework\TestCase;

class PasswordHelperTest extends TestCase
{
    public function testGetHash()
    {
        $passwordhelper = new PasswordHelper();
        $this->assertEquals('005f43de19aed5ebfebc87e0cf71e893', $passwordhelper->getHash('a','b'));
    }

    /**
     * @dataProvider getDataForTestHashPart
     * @param        $expected
     * @param string $token
     */
    public function testHashPart($expected, string $token)
    {
        $passwordhelper = new PasswordHelper();
        $this->assertEquals($expected, $passwordhelper->getHashPart($token));
    }

    public function getDataForTestHashPart(): array
    {
        return [
            ['', ':'],
            ['hash', 'salt:hash'],
        ];
    }
} //TODO интеграционные тесты