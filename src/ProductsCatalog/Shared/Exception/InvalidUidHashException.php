<?php

declare(strict_types=1);

namespace ProductsCatalog\Shared\Exception;

use Throwable;

class InvalidUidHashException extends \InvalidArgumentException
{
    private const MESSAGE = 'Given uid is invalid';

    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }
}
