<?php

declare(strict_types=1);

use Coolblue\Utils\Container\ContainerBuilder;
use Coolblue\Utils\Http\Http;
use Laminas\Diactoros\ResponseFactory;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/../.env');

/** @psalm-suppress PossiblyFalseOperand */
($containerBuilder = new ContainerBuilder())->build(
    $_ENV['ROOT_DIR'] . '/etc/container/container.yml',
    $_ENV['ROOT_DIR'] . '/etc/config/config.yml',
    $_ENV['ROOT_DIR'] . '/cache/container/containerCache.php'
);

$container = $containerBuilder->get();

/** @var Http $http */
$http = $container->get('http');

/** @var $router $router */
$router = $container->get('router');

$request = $http->getRequestFromGlobals();

try {
    $request = $router->preProcessRequest($request);
    $response = $router->processRequest($request);
    $http->outputResponse($response);
} catch (Exception $exception) {
    $response = (new ResponseFactory())->createResponse(500);
    $response->getBody()->write($exception->getMessage());
    $http->outputResponse($response);
}
