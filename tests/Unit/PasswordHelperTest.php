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
    /**
     * @dataProvider getDataForTestGetHash
     *
     * @param        $expected
     * @param        $args
     */
    public function testGetHash($expected, array $args)
    {
        $passwordHelper = new PasswordHelper();
        $this->assertEquals($expected, $passwordHelper->getHash($args[0], $args[1]));
    }

    /**
     * @return array
     */
    public function getDataForTestGetHash(): array
    {
        return [
            ['005f43de19aed5ebfebc87e0cf71e893', ['a', 'b']],
            ['1fd6c79a42a00d38bc65c6ff498dd9b2', ['qwerty', 'asdf1']],
            ['b951b45e6271fe5f0f3006e7f75ca494', ['andrey-lobach', 'bqw2r']],

        ];
    }

    /**
     * @dataProvider getDataForTestHashPart
     *
     * @param        $expected
     * @param string $token
     */
    public function testGetHashPart($expected, string $token)
    {
        $passwordHelper = new PasswordHelper();
        $this->assertEquals($expected, $passwordHelper->getHashPart($token));
    }

    /**
     * @return array
     */
    public function getDataForTestHashPart(): array
    {
        return [
            ['b', 'a:b'],
            ['hash', 'salt:hash'],
            ['lobach', 'andrey:lobach'],
        ];
    }

    /**
     * @dataProvider getDataForTestGetSaltPart
     *
     * @param        $expected
     * @param string $token
     */
    public function testGetSaltPart($expected, string $token)
    {
        $passwordHelper = new PasswordHelper();
        $this->assertEquals($expected, $passwordHelper->getSaltPart($token));
    }

    /**
     * @return array
     */
    public function getDataForTestGetSaltPart(): array
    {
        return [
            ['a', 'a:b'],
            ['zxdasdf', 'zxdasdf:wqerq123aesdaf'],
            ['andrey', 'andrey:lobach'],
        ];
    }

    /**
     * @dataProvider getDataForTestCreateToken
     *
     * @param $expected
     * @param $args
     */
    public function testCreateToken($expected, $args)
    {
        $passwordHelper = new PasswordHelper();
        $this->assertEquals($expected, $passwordHelper->createToken($args[0], $args[1]));
    }

    /**
     * @return array
     */
    public function getDataForTestCreateToken(): array
    {
        return [
            ['b:a', ['a', 'b']],
            ['asdfasdfg:1234adfawe', ['1234adfawe', 'asdfasdfg']],
            ['andrey:lobach', ['lobach', 'andrey']],
        ];
    }
}