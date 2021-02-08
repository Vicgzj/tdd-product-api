<?php

declare(strict_types=1);

use Coolblue\Utils\Http;
use Coolblue\Utils\Router\Router;
use Laminas\Diactoros\ResponseFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router as SymfonyRouter;

require_once __DIR__ . '/../vendor/autoload.php';

$http = new Http();

$fileLocator = new FileLocator(['./../etc']);

$symfonyRouter = new SymfonyRouter(
    new YamlFileLoader($fileLocator),
    'routes.yml',
    ['cache_dir' => './../cache/routing'],
    new RequestContext('/')
);

$router = new Router($symfonyRouter);
$request = $http->getRequestFromGlobals();
$request = $router->preProcessRequest($request);
$response = (new ResponseFactory())->createResponse();
$response->getBody()->write("Hello world");
$http->outputResponse($response);
