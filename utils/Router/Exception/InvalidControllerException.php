<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router\Exception;

use Throwable;

class InvalidControllerException extends RouterException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Invalid controller found for routing', 0, $previous);
    }
}
