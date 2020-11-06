<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiControllerTrait
{
    /**
     * @param array|object $data
     * @param array        $groups
     *
     * @return JsonResponse
     */
    protected function getOkResponse($data, ?array $groups = null): JsonResponse
    {
        $context = [];
        
        if ($groups !== null) {
            $context['groups'] = $groups;
        }
        
        return new JsonResponse(
            $this->container->get('serializer')->serialize(
                $data, 'json', $context
            ),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
    
    /**
     * @return JsonResponse
     */
    protected function getNoContentResponse(): JsonResponse
    {
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
    
    /**
     * @param array|object $data
     * @param array        $groups
     *
     * @return JsonResponse
     */
    protected function getCreatedResponse($data, ?array $groups = null): JsonResponse
    {
        $context = [];
        
        if ($groups !== null) {
            $context['groups'] = $groups;
        }
        
        return new JsonResponse(
            $this->container->get('serializer')->serialize(
                $data, 'json', $context
            ),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
    
    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function getBadRequestResponse(string $message): JsonResponse
    {
        return new JsonResponse(
            ['message' => $message],
            JsonResponse::HTTP_BAD_REQUEST,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
    
    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function getNotFoundResponse(string $message): JsonResponse
    {
        return new JsonResponse(
            ['message' => $message],
            JsonResponse::HTTP_NOT_FOUND,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
