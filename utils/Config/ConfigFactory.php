<?php

declare(strict_types=1);

namespace Coolblue\Utils\Config;

use Coolblue\Utils\Config\Exception\MissingConfigSectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConfigFactory
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $sectionName
     * @return ConfigInterface
     * @throws MissingConfigSectionException
     */
    public function create(string $sectionName): ConfigInterface
    {
        if ($this->container->hasParameter($sectionName) === false) {
            throw new MissingConfigSectionException($sectionName);
        }

        $sectionConfig = $this->container->getParameter($sectionName);

        return new Config($sectionConfig);
    }
}
