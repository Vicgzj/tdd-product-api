<?php

declare(strict_types=1);

use Coolblue\Utils\Http;
use Laminas\Diactoros\ResponseFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$http = new Http();
$request = $http->getRequestFromGlobals();
$response = (new ResponseFactory())->createResponse();
$response->getBody()->write("Hello world");
$http->outputResponse($response);
