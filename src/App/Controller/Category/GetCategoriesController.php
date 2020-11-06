<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Controller\ApiControllerTrait;
use Domain\Repository\CategoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetCategoriesController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/categories", methods="GET")
     */
    public function index(CategoryRepositoryInterface $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->findBy(['parent' => null]);
        
        if (count($categories) === 0) {
            return $this->getNoContentResponse();
        }
        
        return $this->getOkResponse($categories, ['show']);
    }   
}
