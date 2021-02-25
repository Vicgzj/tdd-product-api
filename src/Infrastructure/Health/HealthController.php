<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Health;

use Coolblue\Utils\Http\ContentType;
use Coolblue\Utils\Http\Header;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HealthController implements RequestHandlerInterface
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse();

        $response = $response->withHeader(Header::CONTENT_TYPE, ContentType::JSON);
        $response->getBody()->write(json_encode(['status' => 'OK']));

        return $response;
    }
}
