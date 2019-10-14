<?php

namespace App\Controller;

use App\Entity\Customer;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerController extends FOSRestController
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function register(Request $request,ObjectManager $em)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $fullname = $request->request->get('fullname');
        $customer = new Customer();
        $customer->setFullname($fullname);
        $customer->setUsername($username);
        $customer->setRoles(['ROLE_USER']);
        $customer->setPassword($this->encoder->encodePassword($customer, $password));
        $em->persist($customer);
        $em->flush();
        return New Response(sprintf('Customer %s successfully created', $customer->getUsername()),Response::HTTP_CREATED);
    }
}
