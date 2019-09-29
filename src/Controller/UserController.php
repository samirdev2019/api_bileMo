<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Exception\EntityNotFoundException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Annotations\AnnotationReader;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;


class UserController extends FOSRestController
{
    private $classMetadataFactory;
    private $encoder;
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $this->encoder = new JsonEncoder();
        $this->userRepository = $userRepository;
    }
     /**
     * @Rest\Get(
     *     path = "/users/{id}",
     *     name = "app_user_show",
     *     requirements = {"id"="\d+"}
     * )
     *  @Rest\View(statusCode = 200)
     */
    public function getUserAction($id):Response
    {  
        $user = $this->userRepository->findOneBy(['id' => $id]);
        
        if (!$user) {
            throw new EntityNotFoundException("This user with Id: $id is not found, try with an other user id please");   
        }
        $serializer = $this->getSerializer();
        $data = $serializer->serialize($user, 'json', ['groups' => 'show_user']);
        $response = new Response($data,Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function getSerializer()
    {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
             function ($object, $format, $context) { return $object->getId();},];
            $normalizer = new ObjectNormalizer($this->classMetadataFactory, null, null, null, null, null, $defaultContext);
            $serializer = new Serializer([$normalizer], [$this->encoder]);
            return $serializer;
    }           
}
