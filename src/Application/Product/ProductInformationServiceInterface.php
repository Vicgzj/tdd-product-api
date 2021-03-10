<?php

declare(strict_types=1);

namespace Coolblue\TDD\Application\Product;

use Coolblue\TDD\Domain\Product\Product;

interface ProductInformationServiceInterface
{
    /**
     * @param int $productId
     * @throws ProductException
     * @return Product|null
     */
    public function getProductInformation(int $productId): ?Product;

    public function productExists(int $productId): bool;
}
