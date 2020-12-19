<?php

declare(strict_types=1);

namespace ProductsCatalog\Shared;

use ProductsCatalog\Shared\Exception\InvalidUidHashException;

final class Uid
{
    /** @var string */
    private $hash;

    public function __construct(string $hash = null)
    {
        if ($hash) {
            $this->guardHashPattern($hash);
            $this->hash = $hash;
        } else {
            $this->hash = $this->generate();
        }
    }

    private function generate(): string
    {
        //naive uid generation
        return md5(uniqid((string)mt_rand(), true));
    }

    private function guardHashPattern(string $hash): void
    {
        if (!preg_match('/^[a-f0-9]{32}$/', $hash)) {
            throw new InvalidUidHashException();
        }
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
