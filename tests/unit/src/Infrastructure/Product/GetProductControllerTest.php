<?php

declare(strict_types=1);

namespace Coolblue\Test\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductException;
use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Domain\Product\Product;
use Coolblue\TDD\Infrastructure\Product\GetProductController;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseFactoryInterface;

class GetProductControllerTest extends TestCase
{
    use ProphecyTrait;

    private const PRODUCT_ID = 1234567;
    private const PRODUCT_NAME = 'Product name';
    private const IMAGE_ID = 123456;

    private GetProductController $productController;
    private ObjectProphecy $responseFactory;
    private ObjectProphecy $productInformationService;

    protected function setUp(): void
    {
        $this->responseFactory = $this->prophesize(ResponseFactoryInterface::class);
        $this->productInformationService = $this->prophesize(ProductInformationServiceInterface::class);

        $this->productController = new GetProductController(
            $this->responseFactory->reveal(),
            $this->productInformationService->reveal()
        );
    }

    public function testShouldReturnBadRequestWhenInvalidProductIdOnHandle(): void
    {
        $request = (new ServerRequest())->withAttribute('productId', '1234e234');

        $this->responseFactory
            ->createResponse(StatusCodeInterface::STATUS_BAD_REQUEST)
            ->shouldBeCalled()
            ->willReturn(new EmptyResponse());

        $this->productController->handle($request);
    }

    public function testShouldReturnInternalServerErrorWhenPISThrowsOnHandle(): void
    {
        $request = (new ServerRequest())->withAttribute('productId', (string) self::PRODUCT_ID);

        $this->productInformationService
            ->productExists(self::PRODUCT_ID)
            ->willReturn(true);

        $this->productInformationService
            ->getProductInformation(self::PRODUCT_ID)
            ->willThrow(new ProductException('Exception'));

        $this->responseFactory
            ->createResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR)
            ->shouldBeCalled()
            ->willReturn(new EmptyResponse());

        $this->productController->handle($request);
    }

    public function testShouldReturnNotFoundWhenProductDoesNotExistOnGet(): void
    {
        $request = (new ServerRequest())->withAttribute('productId', (string)self::PRODUCT_ID);

        $this->productInformationService
            ->productExists(self::PRODUCT_ID)
            ->willReturn(false);

        $this->responseFactory
            ->createResponse(StatusCodeInterface::STATUS_NOT_FOUND)
            ->shouldBeCalled()
            ->willReturn(new EmptyResponse());

        $this->productController->handle($request);
    }

    public function testShouldReturnOKWithBodyWhenProductInfoIsFoundOnHandle(): void
    {
        $request = (new ServerRequest())->withAttribute('productId', (string)self::PRODUCT_ID);

        $this->productInformationService
            ->productExists(self::PRODUCT_ID)
            ->willReturn(true);

        $this->productInformationService
            ->getProductInformation(self::PRODUCT_ID)
            ->willReturn($this->getProduct());

        $this->responseFactory
            ->createResponse(StatusCodeInterface::STATUS_OK)
            ->shouldBeCalled()
            ->willReturn(new Response());

        $response = $this->productController->handle($request);

        self::assertNotNull($response->getBody()->getContents());
    }

    private function getProduct(): Product
    {
        return new Product(
            self::PRODUCT_NAME,
            self::PRODUCT_ID,
            self::IMAGE_ID
        );
    }
}
