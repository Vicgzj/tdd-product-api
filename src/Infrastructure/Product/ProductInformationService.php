<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductException;
use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Domain\Product\Product;
use Exception;
use Faker\Factory;

class ProductInformationService implements ProductInformationServiceInterface
{
    /** @var Product[] */
    private array $mockedProductData;

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
        if($this->randomInt(0, 100) === 1) {
            throw new ProductException('Error getting product information');
        }

        return $this->mockProductData()[$productId];
    }

    /**
     * @param int $amountOfProducts
     * @return Product[]
     */
    private function mockProductData(int $amountOfProducts = 5): array
    {
        $faker = Factory::create('lv_LV');
        $products = [];

        if (isset($this->mockedProductData)) {
            return $this->mockedProductData;
        }

        for($i = 0; $i < $amountOfProducts; $i++) {
            $id = $this->randomInt(100000, 999999);
            $imageId = $this->randomInt(100000, 999999);

            $products[] = new Product(
                implode(" ", $faker->words($this->randomInt(1, 3))),
                $id,
                $imageId
            );
        }

        $this->mockedProductData = $products;

        return $this->mockedProductData;
    }

    private function randomInt(int $min, int $max): int
    {
        try {
            return random_int($min, $max);
        } catch (Exception $exception) {
            return (int) floor(($min + $max) / 2);
        }
    }

}
