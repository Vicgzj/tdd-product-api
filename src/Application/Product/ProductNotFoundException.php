<?php

declare(strict_types=1);

namespace Coolblue\TDD\Application\Product;

use Exception;
use Throwable;

class ProductNotFoundException extends Exception
{
    public function __construct($message, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
