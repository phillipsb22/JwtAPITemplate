<?php


namespace App\UserBundle\Tests;


use App\UserBundle\Fixtures\UserFixture;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use \Symfony\Component\HttpFoundation\Response;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class AuthenticationControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function setUp(): void
    {
        $this->loadFixtures(
            [
                UserFixture::class
            ]
        );
    }

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

    public function testPostRegisterUserIncorrectUsername()
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $data = json_encode(
            [
                'username' => 'testinvalidUsername',
                'password' => 't3$tP@ssw0rd'
            ]
        );

        $client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $data
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testPostRegisterUserInvalidPasswordComplexity()
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $data = json_encode(
            [
                'username' => 'testpassword@mail.com',
                'password' => 'testPassword'
            ]
        );

        $client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $data
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testPostRegisterRegisteredUser()
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $data = json_encode(
            [
                'username' => 'testFixtureUser@mail.com',
                'password' => 't3$tP@ssw0rd'
            ]
        );

        $client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $data
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testPostLogin()
    {
        self::ensureKernelShutdown();
        $client = self::createClient();

        $data = json_encode(
            [
                'username' => 'testFixtureUser@mail.com',
                'password' => 't3$tP@ssw0rd'
            ]
        );

        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $data
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}