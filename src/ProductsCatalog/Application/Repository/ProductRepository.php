<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Repository;

use ProductsCatalog\Domain\Product;

interface ProductRepository
{
    public function save(Product $product): void;
}
