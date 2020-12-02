<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Controller\ApiControllerTrait;
use App\Dto\ProductDto;
use App\Service\ValidationService;
use App\Service\SerializationService;
use Domain\Service\Product\CreateProductServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PostProductController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/products", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(
        SerializationService $serializationService,
        ValidationService $validationService,
        CreateProductServiceInterface $createProductService
    ): JsonResponse {
        $dto = $serializationService->deserializeRequestBody(ProductDto::class);
        
        $validationService->validateAndThrowExcetion($dto);
        
        $product = $createProductService->create($dto);
        
        return $this->getCreatedResponse($product, ['create']);
    }
}
