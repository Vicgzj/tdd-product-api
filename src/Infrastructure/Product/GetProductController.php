<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Product;

use Coolblue\TDD\Domain\Product\Product;
use Coolblue\Utils\Http\ContentType;
use Coolblue\Utils\Http\Header;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetProductController implements RequestHandlerInterface
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $product = new Product('Apple IPhone 12 256GB Zwart', 858680, 123456);

        $response = $this->responseFactory->createResponse();
        $response->withHeader(Header::CONTENT_TYPE, ContentType::JSON);
        $response->getBody()->write(json_encode($product, JSON_THROW_ON_ERROR));

        return $response;
    }
}
