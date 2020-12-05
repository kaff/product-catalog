<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\UseCase\AddNewProduct;

class Request
{
    /** @var string */
    public $name;

    /** @var int */
    public $priceAmount;

    /** @var string */
    public $priceCurrency;
}
