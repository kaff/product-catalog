<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Bus\CommandBus;

interface CommandBus
{
    public function handle(Command $command): void;
}
