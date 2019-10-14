<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;
    private $customer;

    public function setUp()
    {
        $this->user = new User();
        $this->customer = new Customer();
        $this->birthDay = new \DateTime;
    }
    /**
     * @test
     */
    public function testGetFirstName()
    {
        $this->user->setFirstName("firstname");
        $result = $this->user->getFirstName();
        $this->assertSame('firstname', $result);
    }
     /**
     * @test
     */
    public function testGetLastName()
    {
        $this->user->setLastName("lastName");
        $result = $this->user->getLastName();
        $this->assertSame('lastName', $result);
    }
    /**
     * @test
     */
    public function testGetAddress()
    {
        $this->user->setAddress("2 avenue de la gare");
        $result = $this->user->getAddress();
        $this->assertSame('2 avenue de la gare', $result);
    }
    public function testGetCustomer()
    {
        $this->user->setCustomer(new Customer());
        $this->assertInstanceOf(Customer::class, $this->user->getCustomer());
    }
    /**
     * @test
     */
    public function testGetBirthDay()
    {
        $this->user->setBirthDay(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $this->user->getBirthDay());
    }
    /**
     * @test
     */
    public function testGetCity()
    {
        $this->user->setCity("2 avenue de la gare");
        $result = $this->user->getCity();
        $this->assertSame('2 avenue de la gare', $result);
    }
    /**
     * @test
     */
    public function testGetEmail()
    {
        $this->user->setEmail("email@gmail.com");
        $result = $this->user->getEmail();
        $this->assertSame('email@gmail.com', $result);
    }
    /**
     * @test
     */
    public function testGetMobileNumber()
    {
        $this->user->setMobileNumber("+33 0 6865XXXX");
        $result = $this->user->getMobileNumber();
        $this->assertSame('+33 0 6865XXXX', $result);
    }
}
