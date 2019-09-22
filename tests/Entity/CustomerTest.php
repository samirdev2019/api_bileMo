<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    private $customer;

    public function setUp()
    {
        $this->customer = new Customer;
    }
    /**
     * @test
     */
    public function testGetFullname()
    {
        $this->customer->setFullname("orange");
        $result = $this->customer->getFullname();
        $this->assertSame('orange', $result);
    }
    /**
     * @test
     */
    public function testGetPassword()
    {
        $this->customer->setPassword('password');
        $result = $this->customer->getPassword();
        $this->assertSame('password', $result);
    }
    /**
     * @test
     */
    public function testGetUsername()
    {
        $this->customer->setUsername('username');
        $result = $this->customer->getUsername();
        $this->assertSame('username', $result);
    }
}
