<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Query;

use ProductsCatalog\Application\Query\GetProduct\DTO;
use ProductsCatalog\Shared\Uid;

interface GetProduct
{
    public function getByUid(Uid $uid): ?DTO\Product;
}
