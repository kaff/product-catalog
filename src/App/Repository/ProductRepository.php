<?php

declare(strict_types=1);

namespace App\Repository;

use ProductsCatalog\Application\Persistence\Handler;
use ProductsCatalog\Application\Repository\ProductRepository as ApplicationProductRepository;
use ProductsCatalog\Domain\Product;

class ProductRepository implements ApplicationProductRepository
{
    /**
     * @var \ProductsCatalog\Application\Persistence\Handler
     */
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function save(Product $product): void
    {
        $products = $this->handler->loadAllFromStorage();
        $products[(string)$product->getUid()] = $product;

        $this->handler->saveInStorage($products);
    }
}
