<?php

declare(strict_types=1);

namespace Coolblue\Test\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Infrastructure\Product\GetProductAccessoriesController;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseFactoryInterface;

class GetProductAccessoriesControllerTest extends TestCase
{
    use ProphecyTrait;

    private GetProductAccessoriesController $productAccessoriesController;
    private ObjectProphecy $responseFactory;
    private ObjectProphecy $productInformationService;

    protected function setUp(): void
    {
        $this->responseFactory = $this->prophesize(ResponseFactoryInterface::class);
        $this->productInformationService = $this->prophesize(ProductInformationServiceInterface::class);

        $this->productAccessoriesController = new GetProductAccessoriesController(
            $this->responseFactory->reveal(),
            $this->productInformationService->reveal()
        );
    }

    /**
     * TODO:
     *  - Write tests for the GetProductAccessories class
     *  - Don't forget about edge cases
     *  - Use the GetProductControllerTest for inspiration
     */
}
