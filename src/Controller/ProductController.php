<?php
/**
 * The ProductController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  App\ProductController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/ProductContoller
 */
namespace App\Controller;

use App\Entity\Product;
use Swagger\Annotations as SWG;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Exception\EntityNotFoundException;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * The Product controller class
 *
 * @category Class
 * @package  App\Controller
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/ProductController
 */
class ProductController extends FOSRestController
{
    /**
     * @var object the product repository
     */
    private $repository;
    private $serializer;
    /**
     * Undocumented function
     *
     * @param ProductRepository $repository   the product repository
     * @param SerializerInterface $serializer the serializer
     */
    public function __construct(ProductRepository $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }
    /**
     * This resource represents a single product in the system.
     * Each product is identified by a numeric `id`.
     *
     * @Rest\Get(
     *     path = "/products/{id}",
     *     name = "app_product_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(StatusCode = Response::HTTP_OK, serializerGroups={"show_product"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the product by id",
     *     @SWG\Schema(ref=@Model(type=Product::class))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="invalid or expired token you need to have a valid access token or refresh it",
     *     @SWG\Property(property="message", type="string",
     *     example="JWT token not found | Expired JWT token"),
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Product not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The product id.",
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
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     * @param integer $id the identifier of product
     * @return response
     */
    public function showAction($id)
    {
        $product = $this->repository->findOneBy(['id' => $id]);
        // 404 response - Resource not found
        if (!$product) {
            throw new EntityNotFoundException(
                "This product with Id: $id is not found, try with an other product id please"
            );
        }
        return $product;
    }
    /**
     * This resource represents a collection of products with pagination
     *
     * @Rest\Get(
     *      path = "/products",
     *      name = "app_product_list"
     * )
     * @Rest\View(
     * StatusCode = Response::HTTP_OK, serializerGroups={"list_product"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the products list",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Product::class, groups={"list_product"}))
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
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function listGetAction(Request $request, PaginatorInterface $paginator):Response
    {
        $queryBuilder = $this->repository->findAllProductQuery();
        $pagination = $paginator->paginate(
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
                  SerializationContext::create()->setGroups(['list_product'])
              ),
              Response::HTTP_OK,
              ['Content-Type' => 'application/json',]
          );
    }
}
