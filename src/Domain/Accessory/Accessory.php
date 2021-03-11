<?php

declare(strict_types=1);

namespace Coolblue\TDD\Domain\Accessory;

use Coolblue\TDD\Domain\Product\Product;
use JsonSerializable;

class Accessory implements JsonSerializable
{
    private string $fullName;
    private int $productId;
    private int $imageId;

    /** @var Product[] */
    private array $coupledProducts;

    /**
     * @param string $fullName
     * @param int $productId
     * @param int $imageId
     * @param Product[] $coupledProducts
     */
    public function __construct(string $fullName, int $productId, int $imageId, array $coupledProducts)
    {
        $this->fullName = $fullName;
        $this->productId = $productId;
        $this->imageId = $imageId;
        $this->coupledProducts = $coupledProducts;
    }

    /**
     * @param Product[] $products
     * @return $this
     */
    public function withProducts(array $products): self
    {
        $clone = clone $this;
        $clone->coupledProducts = $products;

        return $clone;
    }

    public function jsonSerialize(): array
    {
        return [
            'fullName' => $this->fullName,
            'productId' => $this->productId,
            'imageId' => $this->imageId,
        ];
    }
}
