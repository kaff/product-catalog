<?php

declare(strict_types=1);

namespace ProductsCatalog\Domain;

use ProductsCatalog\Shared\Uid;

class Product
{
    /** @var Uid */
    private $uid;

    /** @var string */
    private $name;

    /** @var Money */
    private $price;

    public function __construct(string $name, Money $price, ?Uid $uid = null)
    {
        $this->guardName($name);

        $this->name = $name;
        $this->price = $price;

        if (null === $uid) {
            $this->uid = new Uid();
        }
    }

    private function guardName(string $name): void
    {
        //not implemented yet
    }
}
