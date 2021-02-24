<?php

declare(strict_types=1);

namespace Coolblue\Utils\Router;

use Coolblue\Utils\Config\ConfigInterface;
use Coolblue\Utils\Config\Exception\MissingConfigKeyException;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router as SymfonyRouter;

class RouterFactory
{
    public const CONFIG_KEY_ROUTES_DIR = 'routes_dir';
    public const CONFIG_KEY_ROUTES_FILE = 'routes_file';
    public const CONFIG_KEY_CACHE_DIR = 'cache_dir';

    private ContainerInterface $container;
    private ConfigInterface $config;

    public function __construct(ContainerInterface $container, ConfigInterface $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @return Router
     * @throws MissingConfigKeyException
     */
    public function create(): Router
    {
        $this->validateConfig();

        $fileLocator = new FileLocator([
            $this->config->get(self::CONFIG_KEY_ROUTES_DIR)
        ]);

        $requestContext = new RequestContext('/');

        $router = new SymfonyRouter(
            new YamlFileLoader($fileLocator),
            $this->config->get(self::CONFIG_KEY_ROUTES_FILE),
            ['cache_dir' => $this->config->get(self::CONFIG_KEY_CACHE_DIR)],
            $requestContext
        );

        return new Router($this->container, $router);
    }

    private function validateConfig(): void
    {
        if ($this->config->has(self::CONFIG_KEY_ROUTES_DIR) === false) {
            throw new MissingConfigKeyException(self::CONFIG_KEY_ROUTES_DIR);
        }

        if ($this->config->has(self::CONFIG_KEY_ROUTES_FILE) === false) {
            throw new MissingConfigKeyException(self::CONFIG_KEY_ROUTES_FILE);
        }

        if ($this->config->has(self::CONFIG_KEY_CACHE_DIR) === false) {
            throw new MissingConfigKeyException(self::CONFIG_KEY_CACHE_DIR);
        }
    }
}
