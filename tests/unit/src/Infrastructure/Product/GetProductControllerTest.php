<?php

declare(strict_types=1);

namespace Coolblue\Test\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Infrastructure\Product\GetProductController;
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

    /**
     * Write the tests for this class.
     *
     * Some useful methods:
     * - on prophecies (the mocked responseFactory and productInformationService)
     *      - shouldBeCalled(): asserts that a prophecy method should be called.
     *      - willReturn(<value>): applied to a prophecy, it will return the value when called. Use this to arrange the tests.
     *          Can be chained after shouldBeCalled()
     * - to create a request, use: $request = (new ServerRequest())->withAttribute('productId', self::PRODUCT_ID);
     *
     * The tests should cover at least the happy path described in the Controller itself, but also edge cases.
     *
     * Remember:
     * - A test function should describe what it does, so for instance: testShouldReturnOKWithBodyWhenProductInfoIsFoundOnHandle
     * - Try to use Arrange, Act, Assert
     *
     * Good luck!
     */
}
