<?php

declare(strict_types=1);

namespace App\Presenter\Product;

class ViewObject
{
    /** @var string */
    public $uid;

    /** @var string */
    public $name;

    /** @var int */
    public $priceAmount;

    /** @var string */
    public $priceCurrency;
}
