<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * The backend API returned an error (or could not be reached). The message
 * comes from the API envelope and is safe to show to the user.
 */
class ApiException extends RuntimeException
{
    public function __construct(string $message, public readonly int $status = 500, public readonly mixed $data = null)
    {
        parent::__construct($message, $status);
    }
}
