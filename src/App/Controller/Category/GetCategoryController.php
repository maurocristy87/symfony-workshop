<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Controller\ApiControllerTrait;
use Domain\Repository\CategoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetCategoryController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/categories/{uuid}", methods="GET")
     */
    public function index(
        string $uuid,
        CategoryRepositoryInterface $categoryRepository
    ): JsonResponse {
        $category = $categoryRepository->findOneBy(['uuid' => $uuid]);
        
        if ($category === null) {
            return $this->getNotFoundResponse(sprintf('Category with uuid %s not found', $uuid));
        }
        
        return $this->getOkResponse($category, ['show']);
    }
}
