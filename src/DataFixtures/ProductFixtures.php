<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i=0; $i<=20; $i++) {
            $product = new Product();
            $product->setMark("Sumsung Note$i");
            $product->setReference("P$i Smart 2019");
            $product->setDescription("I'm an description of the product");
            $product->setStorageCapacityROM("160 Go");
            $product->setMemory("4 Go");
            $product->setMaxMemoryCard("255 GO");
            $product->setScreenSize("6\"");
            $product->setPrincipalCameraResolution("12Mpx");
            $product->setSecondCameraResolution("8 Mpx");
            $product->setColor(true);
            $product->setPrice(mt_rand(100, 500));
            $product->setOperatingSystem("ANDROID");
            $product->setProcessor("3X1.53 GHz");
            $product->setCreatedAt(new \DateTime());
            $product->setImageUrl("http://imageurl.it/340X150");
            $manager->persist($product);   
        }
        $manager->flush();
    }
}
