<?php

declare(strict_types=1);

namespace ProductsCatalog\Domain;

final class Currency
{
    /** @var string */
    private $currencyCode;

    public function __construct(string $currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    public function __toString()
    {
        return $this->currencyCode;
    }
}
