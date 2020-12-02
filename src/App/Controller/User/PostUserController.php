<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\ApiControllerTrait;
use App\Dto\UserDto;
use App\Service\ValidationService;
use App\Service\SerializationService;
use Domain\Service\User\CreateUserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostUserController extends AbstractController
{
    use ApiControllerTrait;
    
    /**
     * @Route("/users", methods="POST")
     */
    public function index(
        SerializationService $serializationService,
        ValidationService $validationService,
        CreateUserServiceInterface $createUserService
    ): JsonResponse {
        $dto = $serializationService->deserializeRequestBody(UserDto::class);
        
        $validationService->validateAndThrowExcetion($dto);
        
        $user = $createUserService->create($dto);
        
        return $this->getCreatedResponse($user, ['create']);
    }
}
