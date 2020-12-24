<?php

declare(strict_types=1);

namespace LibraryCatalog\Service\Repository;

use LibraryCatalog\Exception\AppException;

class Exception extends AppException
{
    public function __construct($message = "", $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message == '' ?: 'Repository exception', $code, $previous);
    }
}
