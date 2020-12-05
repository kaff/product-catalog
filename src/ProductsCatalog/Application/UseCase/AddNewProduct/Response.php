<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\UseCase\AddNewProduct;

class Response
{
    /** @var \ProductsCatalog\Domain\Product */
    public $product;

    /** @var \DateTimeInterface */
    public $creationDate;
}
