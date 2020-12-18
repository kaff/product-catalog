<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Bus\CommandBus;

interface CommandHandler
{
    public function handle(Command $command): void;
}
