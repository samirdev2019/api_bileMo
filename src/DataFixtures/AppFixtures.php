<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        for ($i=1; $i <= 3; $i++) {
            $customer = new Customer();
            $customer->setFullname("free $i");
            $customer->setPassword("password");
            $customer->setUsername("username");
            $manager->persist($customer);  
            for ($k=0; $k <= 5; $k++) {
                $user = new User();
                $user->setFirstName("firstname");
                $user->setLastName("lastName");
                $user->setBirthDay(new \DateTime());
                $user->setAddress("2 avenue de la gare");
                $user->setCity("Annecy");
                $user->setCustomer($customer);
                $user->setEmail("email@gmail.com");
                $user->setMobileNumber("+33 0 687887xx");
                $manager->persist($user);  
            }

        }
        $manager->flush();
    }
}
