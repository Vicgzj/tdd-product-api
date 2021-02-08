<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router;

use Exception;
use Throwable;

class RouteNotFoundException extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('No match for routing found', 0, $previous);
    }
}
