<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ServiceValidationException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SerializationService
{
    private const FORMAT = 'json';
    
    private SerializerInterface $serialzier;
    
    private RequestStack $requestSatck;
    
    public function __construct(SerializerInterface $serialzier, RequestStack $requestSatck)
    {
        $this->serialzier = $serialzier;
        $this->requestSatck = $requestSatck;
    }

    public function deserializeRequestBody(string $type): object
    {
        $content = $this->requestSatck->getCurrentRequest()->getContent();
        
        try {
            return $this->serialzier->deserialize($content, $type, 'json', ['allow_extra_attributes' => false]);
        } catch (\Exception $ex) {
            throw new ServiceValidationException($ex->getMessage());
        }
    }
}
