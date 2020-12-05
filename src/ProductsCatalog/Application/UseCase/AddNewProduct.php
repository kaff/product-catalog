<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\UseCase;

use ProductsCatalog\Application\UseCase\AddNewProduct\Request;
use ProductsCatalog\Application\UseCase\AddNewProduct\Response;

interface AddNewProduct
{
    public function execute(Request $request): Response;
}
