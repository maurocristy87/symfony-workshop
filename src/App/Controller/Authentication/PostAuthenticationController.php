<?php

declare(strict_types=1);

namespace App\Controller\Authentication;

use App\Controller\ApiControllerTrait;
use App\Dto\AuthenticationDto;
use App\Service\Security\AuthenticationService;
use App\Service\ValidationService;
use App\Service\SerializationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostAuthenticationController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/authentication", methods="POST")
     */
    public function index(
        SerializationService $serializationService,
        ValidationService $validationService,
        AuthenticationService $authenticationService
    ): JsonResponse {
        $dto = $serializationService->deserializeRequestBody(AuthenticationDto::class);
        
        $validationService->validateAndThrowExcetion($dto);
        return $this->getCreatedResponse($authenticationService->createToken($dto));
    }
}
