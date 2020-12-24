<?php

declare(strict_types=1);

namespace LibraryCatalog\Controller;

use LibraryCatalog\Exception\AppException;

class TransformerException extends AppException
{
    public function __construct($message = "", $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message == '' ?: 'Can not transform object', $code, $previous);
    }
}
