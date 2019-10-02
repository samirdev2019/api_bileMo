<?php

namespace App\Controller;

use App\Entity\Customer;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class CustomerController extends FOSRestController
{
    
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
}