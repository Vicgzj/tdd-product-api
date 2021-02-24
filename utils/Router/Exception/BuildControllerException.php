<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router\Exception;

use Throwable;

class BuildControllerException extends RouterException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Failed to build controller', 0, $previous);
    }
}
