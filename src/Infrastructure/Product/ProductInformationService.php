<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductException;
use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Domain\Product\Product;
use Exception;

class ProductInformationService implements ProductInformationServiceInterface
{
    public function productExists(int $productId): bool
    {
        return isset($this->mockProductData()[$productId]);
    }

    public function getProductInformation(int $productId): ?Product
    {
        if (!$this->productExists($productId)) {
            return null;
        }

        // Simulate that sometimes, this goes wrong.
        try {
            if (random_int(0, 100) === 1) {
                throw new ProductException('Error getting product information');
            }
        } catch (Exception $exception) {
            throw new ProductException('Error getting product information');
        }

        return $this->mockProductData()[$productId];
    }

    /**
     * @return Product[]
     */
    private function mockProductData(): array
    {
        return [
            123456 => new Product('Iphone 12 256GB Black', 123456, 123456),
            666777 => new Product('Haier XC120VWB1R64SR', 666777, 102934),
            733933 => new Product('Iphone 7 128GB Pink', 733933, 345123)
        ];
    }
}
