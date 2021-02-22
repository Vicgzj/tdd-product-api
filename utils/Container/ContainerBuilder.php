<?php

declare(strict_types=1);

namespace Coolblue\Utils\Container;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

class ContainerBuilder
{
    private static ContainerInterface $instance;

    public function build(string $containerYamlFile, string $configYamlFile, string $cacheFile): void
    {
        $configCache = new ConfigCache($cacheFile, false);
        $containerBuilder = new SymfonyContainerBuilder();
        $registerListenersPass = new RegisterListenersPass('event.dispatcher');

        $container = new Container($configCache, $containerBuilder, $registerListenersPass);

        self::$instance = $container->load($containerYamlFile, $configYamlFile);
    }

    /**
     * @return ContainerInterface
     * @throws ContainerNotBuiltException
     */
    public function get(): ContainerInterface
    {
        if (self::$instance === null) {
            throw new ContainerNotBuiltException();
        }

        return self::$instance;
    }
}
