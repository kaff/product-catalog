<?php

declare(strict_types=1);

namespace App\Persistence;

class Handler implements \ProductsCatalog\Application\Persistence\Handler
{
    /**
     * @var string
     */
    private $storagePath;

    public function __construct(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function saveInStorage(array $data): void
    {
        file_put_contents($this->storagePath, serialize($data));
    }

    public function loadAllFromStorage(): array
    {
        $content = @file_get_contents($this->storagePath);

        if (empty($content)) {
            return [];
        }

        return unserialize($content);
    }
}
