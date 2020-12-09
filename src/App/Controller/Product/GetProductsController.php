<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Controller\ApiControllerTrait;
use Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetProductsController extends AbstractController
{
    use ApiControllerTrait;
    
    const DEFAULT_PAGE = 1;
    const DEFAULT_PERPAGE = 5;
    
    /**
     * @Route("/products", methods="GET")
     */
    public function index(Request $request, ProductRepositoryInterface $productRepository): JsonResponse
    {
        $page = $request->query->get('page', self::DEFAULT_PAGE);
        $perPage = $request->query->get('perPage', self::DEFAULT_PERPAGE);
        $filters = $request->query->get('filters', []);
        
        $products = $productRepository->findProductsByFilters((int) $page, (int) $perPage, $filters);
        
        return $this->getOkResponse($products, ['show']);
    }
}
