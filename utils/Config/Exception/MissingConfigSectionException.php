<?php

declare(strict_types=1);

namespace Coolblue\Utils\Config\Exception;

class MissingConfigSectionException extends ConfigException
{
    public function __construct(string $sectionName)
    {
        parent::__construct("Section '$sectionName' was not found in the configuration.");
    }
}
