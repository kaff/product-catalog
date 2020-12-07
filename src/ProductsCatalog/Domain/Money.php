<?php

declare(strict_types=1);

namespace ProductsCatalog\Domain;

final class Money
{
    /** @var int */
    private $amount;

    /** @var Currency */
    private $currency;

    public function __construct(int $amount, Currency $currency)
    {
        $this->guardAmount($amount);

        $this->amount = $amount;
        $this->currency = $currency;
    }

    private function guardAmount(int $amount)
    {
        if ($amount < 0)
        {
            throw new \InvalidArgumentException('Amount cannot be less than 0');
        }
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
