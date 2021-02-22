<?php

declare(strict_types=1);

namespace Coolblue\Utils\Container;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

class Container
{
    private ConfigCache $configCache;
    private ContainerBuilder $containerBuilder;
    private RegisterListenersPass $registerListenersPass;

    public function __construct(
      ConfigCache $configCache,
      ContainerBuilder $containerBuilder,
      RegisterListenersPass $registerListenersPass
    ) {
        $this->configCache = $configCache;
        $this->containerBuilder = $containerBuilder;
        $this->registerListenersPass = $registerListenersPass;
    }

    public function load(string $containerYamlFile, string $configYamlFile): ContainerInterface
    {
        if ($this->configCache->isFresh() === false) {
            $this->buildContainerClass($containerYamlFile, $configYamlFile);
        }

        require_once $this->configCache->getPath();

        /** @var ContainerInterface */
        return new \TDDContainer();
    }

    private function buildContainerClass(string $containerYamlFile, string $configYamlFile): void
    {
        $this->containerBuilder->addCompilerPass($this->registerListenersPass);

        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator(dirname($containerYamlFile)));
        $loader->load(basename($containerYamlFile));

        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator(dirname($configYamlFile)));
        $loader->load(basename($configYamlFile));

        $this->containerBuilder->compile();

        $dumper = new PhpDumper($this->containerBuilder);

        $fileContent = $dumper->dump(['class' => 'TDDContainer']);

        $this->configCache->write($fileContent, $this->containerBuilder->getResources());
    }
}
