<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Persistence;

interface Handler
{
    public function saveInStorage(array $data): void;

    public function loadAllFromStorage(): array;
}
