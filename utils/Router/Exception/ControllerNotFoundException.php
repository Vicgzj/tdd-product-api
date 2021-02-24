<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router\Exception;

use Exception;
use Throwable;

class ControllerNotFoundException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('No controller found for routing', 0, $previous);
    }
}
