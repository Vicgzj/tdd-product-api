<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetProductAccessoriesController implements RequestHandlerInterface
{
    private ResponseFactoryInterface $responseFactory;
    private ProductInformationServiceInterface $productInformationService;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        ProductInformationServiceInterface $productInformationService
    ) {
        $this->responseFactory = $responseFactory;
        $this->productInformationService = $productInformationService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * TODO for this TDD exercise:
         *  - This class should fetch all accessories for the given product from the ProductInformationService(Interface)
         *      and return them in a response
         *  - Turn to the GetProductController for inspiration
         *  - Think about edge cases
        */
        return $this->responseFactory->createResponse();
    }
}
