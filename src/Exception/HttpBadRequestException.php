<?php

declare(strict_types=1);

namespace LibraryCatalog\Exception;

class HttpBadRequestException extends AppException
{
    public function __construct($message = "", $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message == '' ?: 'Bad request', $code, $previous);
    }
}
