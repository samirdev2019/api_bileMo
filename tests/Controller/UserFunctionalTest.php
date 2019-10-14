<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserFunctionalTest extends WebTestCase
{
   
    public function testGetUserWithoutToken()
    {
        $client = static::createClient();
        $client->request('GET', '/users/3');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
    public function testGetUsersWithoutToken()
    {
        $client = static::createClient();
        $client->request('GET', '/users');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
    public function testPutUsersWithoutToken()
    {
        $client = static::createClient();
        $client->request('PUT', '/users/3');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
    public function testPostUsersWithoutToken()
    {
        $client = static::createClient();
        $client->request('POST', '/users');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
}
