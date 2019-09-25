<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends AbstractController
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
    public function showAction(Product $product)
    {
        return $product;
    }
    /**
     * @Rest\Post(
     *      path = "/products",
     *      name = "app_product_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("product", converter="fos_rest.request_body")
     */
    public function createAction(Product $product, ObjectManager $em)
    {
        $em->persist($product);
        $em->flush(); 
       return $this->view(
           '',
           Response::HTTP_CREATED,
           ['Location' => $this->generateUrl(
                'app_product_show', 
                ['id' => $product->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL]
            
            )]
        );
    }
    // /**
    //  * Undocumented function
    //  *
    //  * @param ProductRepository $productRepository
    //  * @return JsonResponse
    //  * @Route("/products", name="app_list_products", methods={"GET"})
    //  */
    // public function listGetAction(SerializerInterface $serializer,ProductRepository $productRepository)
    // { 
    //      $data = $serializer->serialize($productRepository->findAll(), 'json');
    //      $response = new Response($data);
    //      $response->headers->set('Content-Type', 'application/json');
    //      return $response;
    // } 
    /**
     * @Route("/products", name="list_product_page", methods={"GET"})
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
            $request->query->getInt('limit', 3)
        );
    }
}
