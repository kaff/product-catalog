<?php

namespace App\Queue;

final class Status
{
    public const PENDING = 'Pending';

    /** @var string */
    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function __toString()
    {
        return $this->status;
    }
}
