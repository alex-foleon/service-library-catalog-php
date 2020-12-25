<?php

declare(strict_types=1);

namespace LibraryCatalog\Transformer\Serializer;

use Throwable;

class HydrateException extends Exception
{
    /**
     * HydrateException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: 'Can not hydrate object', $code, $previous);
    }
}
