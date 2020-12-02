<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Controller\ApiControllerTrait;
use Domain\Repository\ProductRepositoryInterface;
use Domain\Service\Product\DeleteProductServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DeleteProductController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/products/{uuid}", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(
        string $uuid,
        ProductRepositoryInterface $productRepository,
        DeleteProductServiceInterface $deleteProductService
    ): JsonResponse {
        $product = $productRepository->findOneBy(['uuid' => $uuid]);
        if ($product === null) {
            return $this->getNotFoundResponse(sprintf('Product with uuid %s not found', $uuid));
        }
        
        $deleteProductService->delete($product);
        
        return $this->getOkResponse(null);
    }
}
