<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductFunctionalTest extends WebTestCase
{
   
    public function testGetProductWithoutToken()
    {
        $client = static::createClient();
        $client->request('GET', '/products/3');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
    public function testGetProductsWitToken()
    {
        $client = static::createClient();
        $client->request('GET', '/products');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
  }
