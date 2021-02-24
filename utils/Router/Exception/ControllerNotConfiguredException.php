<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router\Exception;

use Throwable;

class ControllerNotConfiguredException extends RouterException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('No controller found in configured route', 0, $previous);
    }
}
