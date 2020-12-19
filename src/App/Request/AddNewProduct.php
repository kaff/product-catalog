<?php

declare(strict_types=1);

namespace App\Request;

class AddNewProduct
{
    /** @var string */
    public $name;

    /** @var int */
    public $priceAmount;

    /** @var string */
    public $priceCurrency;
}
