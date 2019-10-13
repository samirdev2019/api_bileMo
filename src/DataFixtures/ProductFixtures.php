<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=0; $i<=100; $i++) {
            $product = new Product();
            $product->setMark("Sumsung");
            $product->setReference($faker->bothify('Sumsung ##??'));
            $product->setDescription($faker->sentence($nbWords = 6, $variableNbWords = true));
            $product->setStorageCapacityROM($faker->numberBetween($min = 32, $max = 160)." GO");
            $product->setMemory($faker->numberBetween($min = 1, $max = 12)." GO");
            $product->setMaxMemoryCard($faker->numberBetween($min = 32, $max = 255).'Go');
            $product->setScreenSize($faker->randomDigit.'"');
            $product->setPrincipalCameraResolution($faker->numberBetween($min = 5, $max = 20)."Mpx");
            $product->setSecondCameraResolution($faker->numberBetween($min = 5, $max = 20)."Mpx");
            $product->setColor(true);
            $product->setPrice($faker->randomNumber(2));
            $product->setOperatingSystem("ANDROID");
            $product->setProcessor("3X1.53 GHz");
            $product->setCreatedAt(new \DateTime());
            $product->setImageUrl("http://imageurl.it/340X150");
            $manager->persist($product);   
        }
        $manager->flush();
    }
}
