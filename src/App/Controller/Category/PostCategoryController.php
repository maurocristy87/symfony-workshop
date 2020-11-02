<?php

declare(strict_types=1);

namespace App\Controller;

use Domain\Service\Category\CreateCategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PostCategoryController extends AbstractController
{
    /**
     * @Route("/categories")
     */
    public function index(Request $request, CreateCategoryServiceInterface $service): JsonResponse
    {
        
    }
}
