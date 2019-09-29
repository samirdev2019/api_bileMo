<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Exception\EntityNotFoundException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;

class ProductController extends FOSRestController
{
    private $repository;
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Rest\Get(
     *     path = "/products/{id}",
     *     name = "app_product_show",
     *     requirements = {"id"="\d+"}
     * )
     *  @Rest\View(
     *          statusCode = 200
     * )
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
     * @Rest\Post(
     *      path = "/products",
     *      name = "app_product_create"
     * )
     * @Rest\View(
     * StatusCode = Response::HTTP_CREATED, serializerGroups={"create_product"})
     * @ParamConverter(
     *     "product",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="create_product" }
     *     }
     * )
     */
    public function createAction(Product $product, ObjectManager $em, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }
        $em->persist($product);
        $em->flush(); 
        
        return $this->view(
           $product,
           Response::HTTP_CREATED,
           ['Location' => $this->generateUrl(
                'app_product_show', 
                ['id' => $product->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL]
            
            )]
        );
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
        return $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );
    }
}
