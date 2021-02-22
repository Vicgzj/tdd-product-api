<?php

declare(strict_types=1);

namespace Coolblue\Utils\Http;

use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as ServerRequestInterfaceAlias;

class Http
{
    public function getRequestFromGlobals(): ServerRequestInterfaceAlias
    {
        return ServerRequestFactory::fromGlobals();
    }

    public function outputResponse(ResponseInterface $response): void
    {
        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $header => $values) {
            header("$header: " . implode(', ', $values));
        }

        echo $response->getBody();
    }
}
