<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductException;
use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Domain\Product\Product;
use Coolblue\Utils\Http\ContentType;
use Coolblue\Utils\Http\Header;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetProductController implements RequestHandlerInterface
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
        $productId = $request->getAttribute('productId');

        if ($this->containsOnlyNumbers($productId) === false) {
            return $this->responseFactory->createResponse(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if ($this->productInformationService->productExists((int) $productId) === false) {
            return $this->responseFactory->createResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        try {
            $product = $this->productInformationService->getProductInformation((int) $productId);
        } catch (ProductException $exception) {
            return $this->responseFactory->createResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }

        return $this->createResponse(StatusCodeInterface::STATUS_OK, $product);
    }

    private function containsOnlyNumbers(string $input): bool
    {
        return ctype_digit($input);
    }

    private function createResponse(int $statusCode, Product $product): ResponseInterface
    {
        $response = $this->responseFactory->createResponse($statusCode);
        $response->withHeader(Header::CONTENT_TYPE, ContentType::JSON);
        $response->getBody()->write(json_encode($product, JSON_THROW_ON_ERROR));

        return $response;
    }
}
