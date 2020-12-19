<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Command;

use ProductsCatalog\Application\Bus\CommandBus\Command;

class AddNewProductCommand implements Command
{
    /** @var string */
    private $uid;

    /** @var string */
    private $name;

    /** @var int */
    private $priceAmount;

    /** @var string */
    private $priceCurrency;

    public function __construct(string $uid, string $name, int $priceAmount, string $priceCurrency)
    {
        $this->uid = $uid;
        $this->name = $name;
        $this->priceAmount = $priceAmount;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPriceAmount(): int
    {
        return $this->priceAmount;
    }

    /**
     * @return string
     */
    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }
}
