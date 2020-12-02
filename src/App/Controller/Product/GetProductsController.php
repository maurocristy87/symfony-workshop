<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Controller\ApiControllerTrait;
use Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetProductsController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/products", methods="GET")
     */
    public function index(ProductRepositoryInterface $productRepository): JsonResponse
    {
        return $this->getOkResponse($productRepository->findAll(), ['show']);
    }
}
