<?php

namespace App\Controller;

use App\Entity\Customer;
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
    /**
     * Undocumented function
     *
     * @param Customer $customer
     * @return void
     * @Rest\Get(path ="/customers/{id}", name="app_customer_show")
     */
    public function getCustomer(Customer $customer)
    {
        return $customer;
    }
    /**
     * 
     * @return void
     * 
     * @Rest\Post(path ="/customers", name="app_customer_create")
     * @Rest\View()
     */
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
    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}