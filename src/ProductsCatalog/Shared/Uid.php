<?php

declare(strict_types=1);

namespace ProductsCatalog\Shared;

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
        return md5(uniqid(mt_rand(), true));
    }

    private function guardHashPattern(string $hash): void
    {
        if (!preg_match('/^[a-f0-9]{32}$/', $hash)) {
            throw new \InvalidArgumentException('Given uid is invalid');
        }
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
