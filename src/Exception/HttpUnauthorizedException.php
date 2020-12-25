<?php

declare(strict_types=1);

namespace LibraryCatalog\Exception;

class HttpUnauthorizedException extends AppException
{
    public function __construct($message = "", $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: 'Unauthorized', $code, $previous);
    }
}
