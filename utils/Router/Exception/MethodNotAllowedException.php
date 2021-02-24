<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router\Exception;

use Exception;
use Throwable;

class MethodNotAllowedException extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('This route can not be accessed with the given request method', 0, $previous);
    }
}
