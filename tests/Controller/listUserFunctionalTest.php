<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class listUserFunctionalTest extends WebTestCase
{
   
    public function testgetUsersAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');
        $response = $client->getResponse();
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertJsonResponse($response, 200);
    }
  }