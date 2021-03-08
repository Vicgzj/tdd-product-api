<?php

declare(strict_types=1);

namespace Coolblue\Tests\Infrastructure\Health;

use Coolblue\TDD\Infrastructure\Health\HealthController;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseFactoryInterface;

class HealthControllerTest extends TestCase
{
    use ProphecyTrait;

    private HealthController $healthController;
    private ObjectProphecy $responseFactory;

    protected function setUp(): void
    {
        $this->responseFactory = $this->prophesize(ResponseFactoryInterface::class);
        $this->healthController = new HealthController($this->responseFactory->reveal());
    }

    public function testShouldWorkWhenHealthOnHealth(): void
    {
        $response = new Response();

        $this->responseFactory
            ->createResponse()
            ->willReturn($response);

        self::assertEquals(200, $response->getStatusCode());
    }
}
