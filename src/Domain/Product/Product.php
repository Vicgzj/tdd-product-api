<?php

declare(strict_types=1);

namespace Coolblue\TDD\Domain\Product;

use Coolblue\TDD\Domain\Accessory\Accessory;
use JsonSerializable;

class Product implements JsonSerializable
{
    private string $fullName;
    private int $productId;
    private int $imageId;

    /** @var Accessory[] */
    private array $accessories;

    /**
     * @param string $fullName
     * @param int $productId
     * @param int $imageId
     * @param Accessory[] $accessories
     */
    public function __construct(
        string $fullName,
        int $productId,
        int $imageId,
        array $accessories
    ) {
        $this->fullName = $fullName;
        $this->productId = $productId;
        $this->imageId = $imageId;
        $this->accessories = $accessories;
    }

    public function getAccessories(): array
    {
        return $this->accessories;
    }

    public function jsonSerialize(): array
    {
        return [
            'fullName' => $this->fullName,
            'productId' => $this->productId,
            'imageId' => $this->imageId
        ];
    }
}
