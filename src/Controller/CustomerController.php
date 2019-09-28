<?php
namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;



class CustomerController extends FOSRestController
{
    private $classMetadataFactory;
    public function __construct()
    {
        $this->classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
    }
    /**
     * @Rest\Get(
     *     path = "/customers/{id}",
     *     name = "app_customer_show",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function getCustomerAction(Customer $customer)
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
        AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
         function ($object, $format, $context) { return $object->getFullname();},];
        $normalizer = new ObjectNormalizer($this->classMetadataFactory, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize($customer, 'json', ['groups' => 'users_by_customer']);
        $response = new Response($data,Response::HTTP_OK);
        return $response;  
    }
    // /**
    //  * @Rest\Post(
    //  *      path = "/customers",
    //  *      name = "app_customer_create"
    //  * )
    //  * @Rest\View(StatusCode = 201)
    //  * @ParamConverter("customer", converter="fos_rest.request_body")
    //  */
    // public function postCustomerAction(Customer $customer, ObjectManager $em)
    // {
    //     $em->persist($customer);
    //     $em->flush(); 
    //    return $this->view(
    //        '',
    //        Response::HTTP_CREATED,
    //        ['Location' => $this->generateUrl(
    //             'app_Customer_show', 
    //             ['id' => $customer->getId(),
    //             UrlGeneratorInterface::ABSOLUTE_URL]
            
    //         )]
    //     );
    // }
    // /**
    //  * Undocumented function
    //  *
    //  * @param CustomerRepository $customerRepository
    //  * @return JsonResponse
    //  * @Route("/customers", name="app_list_Customers", methods={"GET"})
    //  */
    // public function getCustomersAction(SerializerInterface $serializer,CustomerRepository $customerRepository)
    // { 
    //      $data = $serializer->serialize($customerRepository->findAll(), 'json');
    //      $response = new Response($data);
    //      $response->headers->set('Content-Type', 'application/json');
    //      return $response;
    // }        
}
