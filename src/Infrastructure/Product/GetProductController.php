<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Domain\Product\Product;
use Coolblue\Utils\Http\ContentType;
use Coolblue\Utils\Http\Header;
use Fig\Http\Message\StatusCodeInterface;
use JsonException;
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
        /** @var string $productId */
        $productId = $request->getAttribute('productId');

        /**
         * Happy path acceptance criteria for this controller:
         * - As a consumer, when I enter a valid productId, I want to see a product in json format.
         *
         * The objective of this workshop is to meet this acceptance criteria, TDD style.
         * So, write a test, that should be red, write the code to make the test go green and refactor where needed.
         * The tests file can be found in tests/unit/src/Infrastructure/Product (or use shortcut cmd + shift + t)
         *
         * Don't only write the happy path, but think of edge cases. For instance:
         * - What if the product doesn't exist
         * - What if a customer gives an invalid productId
         *
         * Write down as much cases as you can. I could think of 5 possible outcomes. If you have more ideas, go ahead!
         *
         * Extra info:
         * - Use the $this->productInformationService->getProductInformation(<productId>) method to find information for the product
         * - Use $this->responseFactory->createResponse(<StatusCodeInterface::STATUS_CODE>) to return an empty response
         * - Use $this->createResponseWithJson to return a json response.
         * - For HTTP status codes, remember:
         *      - 2xx indicates a success response;
         *      - 4xx indicates a problem on the clients' side;
         *      - 5xx indicates a problem on the servers' side.
         * - Use your IDE! It will (most probably) indicate that some things can/will go wrong.
         *
         * Good luck!
         */

        // Return an empty response.
        return $this->responseFactory->createResponse(StatusCodeInterface::STATUS_NOT_IMPLEMENTED);
    }

    private function containsOnlyNumbers(string $input): bool
    {
        return ctype_digit($input);
    }

    /**
     * @param int $statusCode
     * @param Product $product
     * @return ResponseInterface
     * @throws JsonException
     */
    private function createResponseWithJson(int $statusCode, Product $product): ResponseInterface
    {
        $response = $this->responseFactory->createResponse($statusCode);
        $response->withHeader(Header::CONTENT_TYPE, ContentType::JSON);
        $response->getBody()->write(json_encode($product, JSON_THROW_ON_ERROR));

        return $response;
    }
}
