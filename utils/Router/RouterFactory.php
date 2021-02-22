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
    /**
     * @return Router
     */
    public function create(): Router
    {
        $fileLocator = new FileLocator(['./../etc/routing']);

        $requestContext = new RequestContext('/');

        $router = new SymfonyRouter(
            new YamlFileLoader($fileLocator),
            'routes.yml',
            ['cache_dir' => './../cache/routing'],
            $requestContext
        );

        return new Router($router);
    }
}
