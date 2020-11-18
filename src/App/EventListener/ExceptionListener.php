<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use App\Exception\ServiceValidationException as AppServiceValidationException;
use Domain\Exception\ServiceValidationException as DomainServiceValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();
        
        $responseData = ['message' => 'Internal server error.'];
        $httpCode = 500;
        
        if ($exception instanceof AppServiceValidationException || $exception instanceof DomainServiceValidationException) {
            $responseData = ['message' => $exception->getMessage()];
            $httpCode = JsonResponse::HTTP_BAD_REQUEST;
        } elseif ($exception instanceof AccessDeniedHttpException) {
            $responseData = ['message' => 'Access denied'];
            $httpCode = $exception->getStatusCode();
        } elseif ($exception instanceof ValidationException) {
            $responseData = [
                'message' => $exception->getMessage(),
                'errors' => $exception->getViolations()
            ];
            $httpCode = JsonResponse::HTTP_BAD_REQUEST;
        }
        
        $response->setData($responseData);
        $response->setStatusCode($httpCode);
        
        $event->setResponse($response);
    }
}
