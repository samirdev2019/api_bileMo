<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Customer;
use Swagger\Annotations as SWG;
use Swagger\Annotations\Property;
use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface; 
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Exception\EntityNotFoundException;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Annotations\AnnotationReader;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
      * get user by the identifier 'id'
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
      * @SWG\Response(
     *     response=200,
     *     description="OK, Returned when the user is getted",
     *     @SWG\Schema(ref=@Model(type=User::class))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="invalid or expired token, you need to have a valid access token or refresh it",
     *     @SWG\Property(property="message", type="string",
     *     example="JWT token not found | Expired JWT token"),
     * )
     * @SWG\Response(
     *     response="404",
     *     description="User not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user identifier.",
     *     required=true,
     *     type="integer"
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
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
     * Adds a new user : 
     *   if created the resource absolute url location will be added to the header 
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
     * 
     * @SWG\Response(
     *     response=201,
     *     description="returned when Created",
     *     @Model(type=User::class, groups={"update_user"})
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad Request: Returned when a violation is raised by validation",
     * )
     * @SWG\Response(
     *     response="401",
     *     description="invalid or expired token you need to have a valid access token or refresh it",
     *     @SWG\Property(property="message", type="string",
     *     example="JWT token not found | Expired JWT token"),
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="Content-Type",
     *     in="header",
     *     default="application/json",
     *     description="application/json",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(type="object",
     *          @SWG\Property(property="user", ref=@Model(type=User::class, groups={"update_user"})))
     *)
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
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
     * Delete a resource user by id 
     *  returns an empty body and a status code 204
     *
     * @param integer $id
     * @return View
     * @Rest\Delete(path = "/users/{id}",name = "app_user_delete" )
     * 
     * @SWG\Response(
     *     response=204,
     *     description="No content : deleted user",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No route found"
     * )
     * @SWG\Response(
     *     response="401",
     *     description="invalid or expired token you need to have a valid access token or refresh it",
     *     @SWG\Property(property="message", type="string",
     *     example="JWT token not found | Expired JWT token"),
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
    */
    public function deleteUsersAction(int $id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if($user) {
            $this->em->remove($user);
            $this->em->flush();
        }
       
        return $this->view(null,Response::HTTP_NO_CONTENT);
    }
    
     /**
     * get the list of users linked to a customer
     *
     * @param integer $id
     * @return void
     * @Rest\Get(
     *     path = "/customers/{id}/users",
     *     name = "app_get_users"
     * )
     * @Rest\View(StatusCode = Response::HTTP_OK, serializerGroups={"users_by_customer"})
     * 
      * @SWG\Response(
     *     response=200,
     *     description="OK: the users list is returned",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"users_by_customer"}))
     *     )
     *     )
     * @SWG\Response(
     *     response="401",
     *     description="invalid or expired token you need to have a valid access token or refresh it",
     *     @SWG\Property(property="message", type="string",
     *     example="JWT token not found | Expired JWT token"),
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="The field used to navigate in the list of products"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     description="The field used to fix the number of products per page"
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
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
     * 
     * @SWG\Response(
     *     response=200,
     *     description="returned when Updated",
     *     @Model(type=User::class, groups={"update_user"})
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad Request: Returned when a violation is raised by validation",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="you want update the user with not found id !",
     * )
     * @SWG\Response(
     *     response="401",
     *     description="invalid or expired token you need to have a valid access token or refresh it",
     *     @SWG\Property(property="message", type="string",
     *     example="JWT token not found | Expired JWT token"),
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user id.",
     *     required=true,
     *     type="integer"
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="Content-Type",
     *     in="header",
     *     default="application/json",
     *     description="application/json",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(type="object",
     *          @SWG\Property(property="user", ref=@Model(type=User::class, groups={"update_user"})))
     *)
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
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
        //return$this->handleView($this->view($form->getErrors()));
    }
}
