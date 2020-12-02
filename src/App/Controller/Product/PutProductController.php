<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Controller\ApiControllerTrait;
use App\Dto\ProductDto;
use App\Service\ValidationService;
use App\Service\SerializationService;
use Domain\Repository\ProductRepositoryInterface;
use Domain\Service\Product\UpdateProductServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PutProductController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/products/{uuid}", methods="PUT")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(
        string $uuid,
        SerializationService $serializationService,
        ValidationService $validationService,
        ProductRepositoryInterface $productRepository,
        UpdateProductServiceInterface $updateProductService
    ): JsonResponse {
        $product = $productRepository->findOneBy(['uuid' => $uuid]);
        if ($product === null) {
            return $this->getNotFoundResponse(sprintf('Product with uuid %s not found', $uuid));
        }
        
        $dto = $serializationService->deserializeRequestBody(ProductDto::class);
        $validationService->validateAndThrowExcetion($dto);
        
        $product = $updateProductService->update($product, $dto);
        
        return $this->getOkResponse($product, ['show']);
    }
}
