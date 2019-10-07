<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use App\Exception\EntityNotFoundException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends FOSRestController
{
    private $repository;
    private $serializer;
    public function __construct(ProductRepository $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }
    /**
     * @Rest\Get(
     *     path = "/products/{id}",
     *     name = "app_product_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(StatusCode = Response::HTTP_OK, serializerGroups={"show_product"})
     */
    public function showAction($id)
    {
        $product = $this->repository->findOneBy(['id' => $id]);
        // 404 response - Resource not found
        if (!$product) {   
            throw new EntityNotFoundException("This product with Id: $id is not found, try with an other product id please");   
        }
        return $product;
    }
    /**
     * @Rest\Get(
     *      path = "/products",
     *      name = "app_product_list"
     * )
     * @Rest\View(
     * StatusCode = Response::HTTP_OK, serializerGroups={"list_product"})
     */
    public function listGetAction(Request $request, PaginatorInterface $paginator)
    {
         $queryBuilder = $this->repository->findAllProductQuery();
        
        if ($request->query->getAlnum('filter')) {
            $products->where('bp.mark LIKE :mark')
                ->setParameter('mark', '%' . $request->query->getAlnum('filter') . '%');
        }
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
