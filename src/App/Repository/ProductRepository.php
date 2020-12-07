<?php

declare(strict_types=1);

namespace App\Repository;

use ProductsCatalog\Application\Repository\ProductRepository as ApplicationProductRepository;
use ProductsCatalog\Domain\Product;

class ProductRepository implements ApplicationProductRepository
{
    /**
     * @var string
     */
    private $storagePath;

    public function __construct(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function save(Product $product): Product
    {
        $classes = $this->getFromStorage();
        $classes[(string)$product->getUid()] = $product;

        $this->saveInStorage($classes);

        return $product;
    }

    private function saveInStorage($data)
    {
        file_put_contents($this->storagePath, serialize($data));
    }

    private function getFromStorage(): array
    {
        $content = @file_get_contents($this->storagePath);

        if (empty($content)) {
            return [];
        }

        return unserialize($content);
    }
}
