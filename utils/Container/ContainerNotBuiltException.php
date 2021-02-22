<?php

declare(strict_types=1);

namespace Coolblue\Utils\Container;

use Exception;

class ContainerNotBuiltException extends Exception
{
    public function __construct()
    {
        parent::__construct('The container has not been built yet.');
    }
}
