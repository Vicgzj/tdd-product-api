<?php

declare(strict_types=1);

namespace Coolblue\Utils\Config\Exception;

class MissingConfigKeyException extends ConfigException
{
    public function __construct(string $key)
    {
        parent::__construct("Key '$key' was not found in the configuration.");
    }
}
