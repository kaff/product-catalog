<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Query\GetProduct;

use ProductsCatalog\Application\Persistence\Handler;
use ProductsCatalog\Application\Query\GetProduct;
use ProductsCatalog\Domain\Product;
use ProductsCatalog\Shared\Uid;

class Query implements GetProduct
{
    /**
     * @var Handler
     */
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function getByUid(Uid $uid): ?DTO\Product
    {
        $products = $this->handler->loadAllFromStorage();
        $product = $products[(string)$uid] ?? null;

        if (null === $product) {
            return null;
        }

        return $this->mapToDTO($product);
    }

    private function mapToDTO(Product $product)
    {
        $dto = new DTO\Product();
        $dto->uid = $product->getUid();
        $dto->name = $product->getName();
        $dto->price = $product->getPrice();

        return $dto;
    }
}
