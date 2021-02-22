<?php
declare(strict_types=1);

use Coolblue\Utils\Container\ContainerBuilder;
use Coolblue\Utils\Router\Router;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../../../vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/../../../.env');

/** @psalm-suppress PossiblyFalseOperand */
($containerBuilder = new ContainerBuilder())->build(
    $_ENV['ROOT_DIR'] . '/etc/container/container.yml',
    $_ENV['ROOT_DIR'] . '/etc/config/config.yml',
    $_ENV['ROOT_DIR'] . '/cache/container/containerCache.php'
);
$container = $containerBuilder->get();

/** @var Router $router */
$router = $container->get('router');
$router->warm();
