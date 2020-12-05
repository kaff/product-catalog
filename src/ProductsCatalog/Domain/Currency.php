<?php

declare(strict_types=1);

namespace ProductsCatalog\Domain;

final class Currency
{
    /** @var string */
    private $currencyCode;

    public function __construct(string $currencyCode)
    {
        $this->guardCurrencyCode($currencyCode);
        $this->currencyCode = $currencyCode;
    }

    public function __toString()
    {
        return $this->currencyCode;
    }

    private function guardCurrencyCode(string $currencyCode)
    {
        if (strlen($currencyCode) !== 3) {
            throw new \InvalidArgumentException('Invalid currency code. Currency code must be 3 characters long.');
        }
    }
}
