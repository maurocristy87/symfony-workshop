<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationService
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    /**
     * @param object $model
     * @param array|null $groups default null
     *
     * @return array violations
     */
    public function validate(object $model, ?array $groups = null): array
    {
        return $this->violationsToArray($this->validator->validate($model, null, $groups));
    }
    
    /**
     * @param object $model
     * @param array $groups
     *
     * @return void
     *
     * @throws ValidatorException
     */
    public function validateAndThrowExcetion(object $model, ?array $groups = null): void
    {
        $violations = $this->validate($model, $groups);
        
        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }
    }
    
    /**
     * @param ConstraintViolationListInterface $violations
     *
     * @return array
     */
    protected function violationsToArray(ConstraintViolationListInterface $violations): array
    {
        $messages = [];

        foreach ($violations as $violation) {
            $messages[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $messages;
    }
}
