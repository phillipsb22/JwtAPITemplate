<?php


namespace App\UserBundle\Tests;


use App\Tests\DatabasePrimer;
use \Symfony\Component\HttpFoundation\Response;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class AuthenticationControllerTest extends WebTestCase
{
//    public function setUp(): void
//    {
//        parent::setUp();
//
//        self::bootKernel();
//
//        DatabasePrimer::prime(self::$kernel);
//    }

    public function testPostRegisterUser()
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->request(
            'POST',
            '/api/register',
            [
                'username' => 'testuser@mail.com',
                'password' => 'T3stP@ssw0rd'
            ]
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

//    public function testPostLogin()
//    {
//        dd('nHere');
//    }
}