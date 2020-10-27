<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class GetIndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Symfony Workshop API'
        ]);
    }
}
