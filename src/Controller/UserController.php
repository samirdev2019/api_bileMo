<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Customer;
use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use JMS\Serializer\SerializationContext;
use App\Exception\EntityNotFoundException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Annotations\AnnotationReader;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\Serializer\SerializerInterface; 

class UserController extends FOSRestController
{
    private $userRepository;
    private $em;
    private $customerRepository;
    private $serializer;
    public function __construct(
        SerializerInterface $serializer,
        UserRepository $userRepository,
        ObjectManager $em,
        CustomerRepository $customerRepository
    ) {
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
        $this->em = $em;
        $this->serializer = $serializer;

    }
   
    /**
      * this method allows to read from a resource via the HTTP method GET
      * returns the resource in the body and a status code 200
      * if the user not found it generate an exception with the code status 4O4
      *
      * @param int $id the identifier of user
      * @return Response
      *
      * @Rest\Get(
      *     path = "/users/{id}",
      *     name = "app_user_show",
      *     requirements = {"id"="\d+"}
      * )
      * @Rest\View(StatusCode = Response::HTTP_CREATED, serializerGroups={"show_user"})
    */
    public function getUserAction($id)
    {  
        $user = $this->userRepository->findOneBy(['id' => $id]);
        
        if (!$user) {
            throw new EntityNotFoundException("This user with Id: $id is not found, try with an other user id please");   
        }
         $data = $this->serializer->serialize($user, 'json');
         $response = new Response($data,Response::HTTP_OK);
         $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * This method allows to create a resource "user" via the method HTTP POST
     *  returns the resource in the body and a code status 201, and adds an resource absolute url location to the header 
     * 
     * @param User $user
     * @param Request $request
     * @param ConstraintViolationList $violations
     * @return View
     * 
     * @Rest\Post(path = "/users",name = "app_user_create")
     * @Rest\View(StatusCode = Response::HTTP_CREATED, serializerGroups={"show_user"})
     * @ParamConverter(
     *     "user",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="create_user" }
     *     }
     * )
    */

    public function postUserAction(User $user, Request $request,ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }
        $customer = new Customer();
        $data = $request->getContent();
        $user = $this->serializer->deserialize($data,User::class, 'json');        
        $user->setCustomer($this->getUser());
        $this->em->persist($user);
        $this->em->flush();
        return $this->view(
            $user,
            Response::HTTP_CREATED,
            ['Location' => $this->generateUrl(
                'app_user_show', 
                ['id' => $user->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL]
            )]
        );
    }
    /**
     * this method allows to delete a resource "user" via the HTTP method DELETE
     *  returns an empty body and a status code 204
     * I have not thrown an exception here, in the case where the object dn't
     * exist; as the customer want to remove the object,a no content response will be sent
     *
     * @param integer $id
     * @return View
     * @Rest\Delete(path = "/users/{id}",name = "app_user_delete" )
    */
    public function deleteUsersAction(int $id): View
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if($user) {
            $this->em->remove($user);
            $this->em->flush();
        }
       
        return $this->view(null,Response::HTTP_NO_CONTENT);
    }
    
     /**
     * This method allows to view the collection of registered users linked to a customer on the website
     * via the method GET returns the collection and a status code 200  
     *
     * @param integer $id
     * @return void
     * @Rest\Get(
     *     path = "/customers/{id}/users",
     *     name = "app_get_users"
     * )
     * @Rest\View(StatusCode = Response::HTTP_OK, serializerGroups={"users_by_customer"})
     */
    public function getCostomersUsersAction(Request $request, int $id, PaginatorInterface $paginator)
    {
        $queryBuilder = $this->userRepository->findAllByCustomerIdQuery($id);
        
        $pagination =  $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );
        $result = array(
            'data' => $pagination->getItems(),
            'meta' => $pagination->getPaginationData());
           
          return new Response(
              $this->serializer->serialize(
                  $result,
                  'json',
                  SerializationContext::create()->setGroups(['users_by_customer'])
              ),
              Response::HTTP_OK,
              ['Content-Type' => 'application/json',]
          );
    }
    /**
     * @Rest\Put(path = "/users/{id}", name = "app_user_update")
     * @Rest\View(StatusCode = Response::HTTP_OK, serializerGroups={"update_user"})
     */
    public function updateUserAction(Request $request, int $id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if (!$user) {
            throw new EntityNotFoundException("you want update the user with Id: $id but is not found, try with an other user id please !");   
        }
        $form = $this->createForm(UserType::class, $user);  
        $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $this->em->flush();
            return $user;
        } else {
            return $form;
        }
    }
}
