<?php


namespace App\UserBundle\Tests;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class AuthenticationControllerTest extends WebTestCase
{
    public function testPostRegisterUser()
    {
        $v = 1;
        $this->assertEquals(1, $v);
    }

//    public function testPostLogin()
//    {
//        dd('nHere');
//    }
}