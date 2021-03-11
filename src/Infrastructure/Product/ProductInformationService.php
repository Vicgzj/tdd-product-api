<?php

declare(strict_types=1);

namespace Coolblue\TDD\Infrastructure\Product;

use Coolblue\TDD\Application\Product\ProductException;
use Coolblue\TDD\Application\Product\ProductInformationServiceInterface;
use Coolblue\TDD\Application\Product\ProductNotFoundException;
use Coolblue\TDD\Domain\Accessory\Accessory;
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
            $productName = $faker->sentence(3);
            $id = $i;
            $imageId = $i;

            $accessories = [];

            for($j = 0; $j < 4; $j++) {
                $accessoryName = $faker->sentence(1);
                $accessoryId = (int)($i . $j);
                $accessoryImageId = (int)($i . $j);

                $accessories[] = new Accessory(
                    $accessoryName,
                    $accessoryId,
                    $accessoryImageId,
                    []
                );
            }

            $products[] = new Product(
                $productName,
                $id,
                $imageId,
                $accessories
            );
        }

        $this->mockedProductData = $products;

        return $this->mockedProductData;
    }

    /** @inheritDoc */
    public function getProductAccessories(int $productId): array
    {
        if (!$this->productExists($productId)) {
            throw new ProductNotFoundException('Product id ' . $productId . ' not found.');
        }

        $product = $this->mockProductData()[$productId];

        // Simulate that sometimes, this goes wrong.
        try {
            if (random_int(0, 100) === 1) {
                throw new ProductException('Error getting product information');
            }
        } catch (Exception $exception) {
            throw new ProductException('Error getting product information');
        }

        return $product->getAccessories();
    }

}
