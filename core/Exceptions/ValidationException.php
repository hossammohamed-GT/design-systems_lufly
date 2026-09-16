<?php

declare(strict_types=1);

namespace Core\Exceptions;

class ValidationException extends AppException
{
    protected int $httpStatus = 422;

    protected string $errorCode = 'validation_failed';

    /** @param array<string, string[]> $errors field => messages */
    public function __construct(private readonly array $errors = [], string $message = '')
    {
        parent::__construct($message !== '' ? $message : 'The given data was invalid.');
    }

    /** @return array<string, string[]> */
    public function errors(): array
    {
        return $this->errors;
    }
}
