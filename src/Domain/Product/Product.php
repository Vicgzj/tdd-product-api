<?php

declare(strict_types=1);

namespace Coolblue\TDD\Domain\Product;

use JsonSerializable;

class Product implements JsonSerializable
{
    private string $fullName;
    private int $productId;
    private int $imageId;

    /**
     * @param string $fullName
     * @param int $productId
     * @param int $imageId
     */
    public function __construct(
        string $fullName,
        int $productId,
        int $imageId
    ) {
        $this->fullName = $fullName;
        $this->productId = $productId;
        $this->imageId = $imageId;
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
