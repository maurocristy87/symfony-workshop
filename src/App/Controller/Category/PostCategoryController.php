<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Controller\ApiControllerTrait;
use App\Dto\CategoryDto;
use App\Service\SerializationService;
use Domain\Service\Category\CreateCategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostCategoryController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/categories", methods="POST")
     */
    public function index(
        SerializationService $serializationService,
        CreateCategoryServiceInterface $createCategoryService
    ): JsonResponse {
        $dto = $serializationService->deserializeRequestBody(CategoryDto::class);
        
        $category = $createCategoryService->create($dto);
        
        return $this->getCreatedResponse($category, ['create']);
    }
}
