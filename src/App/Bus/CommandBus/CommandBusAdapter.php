<?php

declare(strict_types=1);

namespace App\Bus\CommandBus;

use ProductsCatalog\Application\Bus\CommandBus\Command;
use ProductsCatalog\Application\Bus\CommandBus\CommandBus as ProductsCatalogCommandBus;
use League\Tactician\CommandBus;

class CommandBusAdapter implements ProductsCatalogCommandBus
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Command $command): void
    {
        $this->commandBus->handle($command);
    }
}
