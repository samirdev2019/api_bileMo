<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $username = ['orange','free'];
        $password = ['password','password'];
        for ($i=0; $i <=1; $i++) {
            $customer = new Customer();
                $customer->setFullname($faker->company);
                $customer->setUsername($username[$i]);
                $customer->setRoles(['ROLE_USER']);
                $customer->setPassword($this->encoder->encodePassword($customer, $password[$i]));
                $manager->persist($customer);
            for ($k=0; $k <= 50; $k++) {
                $user = new User();
                $user->setFirstName($faker->firstNameMale);
                $user->setLastName($faker->lastName());
                $user->setBirthDay(new \DateTime());
                $user->setAddress($faker->streetAddress);
                $user->setCity($faker->city);
                $user->setCustomer($customer);
                $user->setEmail($faker->email);
                $user->setMobileNumber($faker->e164PhoneNumber);
                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}
