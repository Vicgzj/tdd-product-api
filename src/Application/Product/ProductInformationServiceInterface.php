<?php

declare(strict_types=1);

namespace Coolblue\TDD\Application\Product;

use Coolblue\TDD\Domain\Product\Product;

interface ProductInformationServiceInterface
{
    /**
     * @param int $productId
     * @throws ProductException when it fails to fetch product information
     * @return Product|null Product when product is found, else null.
     */
    public function getProductInformation(int $productId): ?Product;

    public function productExists(int $productId): bool;
}
