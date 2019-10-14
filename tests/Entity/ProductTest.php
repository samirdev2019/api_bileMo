<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $product;

    public function setUp()
    {
        $this->product= new Product();
    }
    /**
    * @test
    */
    public function testGetMark()
    {
        $this->product->setMark("Sumsung");
        $result = $this->product->getMark();
        $this->assertSame('Sumsung', $result);
    }
    /**
    * @test
    */
    public function testGetReference()
    {
        $this->product->setReference("P Smart 2019");
        $result = $this->product->getReference();
        $this->assertSame('P Smart 2019', $result);
    }
    /**
    * @test
    */
    public function testGetDescription()
    {
        $this->product->setDescription("je suis une description du produit");
        $result = $this->product->getDescription();
        $this->assertSame('je suis une description du produit', $result);
    }
    /**
    * @test
    */
    public function testGetStorageCapacityROM()
    {
        $this->product->setStorageCapacityROM("250 GO");
        $result = $this->product->getStorageCapacityROM();
        $this->assertSame('250 GO', $result);
    }
    /**
    * @test
    */
    public function testGetMemory()
    {
        $this->product->setMemory("2 GO");
        $result = $this->product->GetMemory();
        $this->assertSame('2 GO', $result);
    }
    /**
    * @test
    */
    public function testGetMaxMemoryCard()
    {
        $this->product->setMaxMemoryCard("255 GO");
        $result = $this->product->GetMaxMemoryCard();
        $this->assertSame('255 GO', $result);
    }
    /**
    * @test
    */
    public function testGetScreenSize()
    {
        $this->product->setScreenSize('6"');
        $result = $this->product->GetScreenSize();
        $this->assertSame('6"', $result);
    }
    /**
    * @test
    */
    public function testGetPrincipalCameraResolution()
    {
        $this->product->setPrincipalCameraResolution("12Mpx");
        $result = $this->product->GetPrincipalCameraResolution();
        $this->assertSame('12Mpx', $result);
    }
    /**
    * @test
    */
    public function testGetSecondCameraResolution()
    {
        $this->product->setSecondCameraResolution("8 Mpx");
        $result = $this->product->GetSecondCameraResolution();
        $this->assertSame('8 Mpx', $result);
    }
    /**
    * @test
    */
    public function testGetColor()
    {
        $this->product->setColor(true);
        $this->assertTrue($this->product->GetColor());
    }
    /**
    * @test
    */
    public function testGetPrice()
    {
        $this->product->setPrice(300);
        $result = $this->product->getPrice();
        $this->assertEquals(300, $result);
    }
    /**
    * @test
    */
    public function testGetOperatingSystem()
    {
        $this->product->setOperatingSystem("ANDROID");
        $result = $this->product->getOperatingSystem();
        $this->assertSame('ANDROID', $result);
    }
    /**
    * @test
    */
    public function testGetProcessor()
    {
        $this->product->setProcessor("3X1.53 GHz");
        $result = $this->product->getProcessor();
        $this->assertSame('3X1.53 GHz', $result);
    }
    public function testGetCreatedAt()
    {
        $this->product->setCreatedAt(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $this->product->getCreatedAt());
    }
    public function testGetImageUrl()
    {
        $this->product->setImageUrl("http://imageurl.it/340X150");
        $result = $this->product->getImageUrl();
        $this->assertSame('http://imageurl.it/340X150', $result);
    }
}
