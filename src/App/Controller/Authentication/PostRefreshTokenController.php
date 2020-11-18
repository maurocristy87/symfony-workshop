<?php

declare(strict_types=1);

namespace App\Controller\Authentication;

use App\Controller\ApiControllerTrait;
use App\Dto\RefreshTokenDto;
use App\Service\Security\AuthenticationService;
use App\Service\ValidationService;
use App\Service\SerializationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostRefreshTokenController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/authentication/refresh", methods="POST")
     */
    public function index(
        SerializationService $serializationService,
        ValidationService $validationService,
        AuthenticationService $authenticationService
    ): JsonResponse {
        $dto = $serializationService->deserializeRequestBody(RefreshTokenDto::class);
        
        $validationService->validateAndThrowExcetion($dto);
        return $this->getCreatedResponse($authenticationService->refreshToken($dto));
    }
}
