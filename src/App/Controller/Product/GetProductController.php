<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Controller\ApiControllerTrait;
use Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetProductController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/products/{uuid}", methods="GET")
     */
    public function index(
        string $uuid,
        ProductRepositoryInterface $productRepository
    ): JsonResponse {
        $product = $productRepository->findOneBy(['uuid' => $uuid]);
        
        if ($product === null) {
            return $this->getNotFoundResponse(sprintf('Product with uuid %s not found', $uuid));
        }
        
        return $this->getOkResponse($product, ['show']);
    }
}
