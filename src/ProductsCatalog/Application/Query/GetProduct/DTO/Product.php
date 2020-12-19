<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Query\GetProduct\DTO;

use ProductsCatalog\Domain\Money;
use ProductsCatalog\Shared\Uid;

class Product
{
    /** @var Uid */
    public $uid;

    /** @var string */
    public $name;

    /** @var Money */
    public $price;
}
