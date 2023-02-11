<?php

namespace App\Application\Commands;

use App\Application\Helpers\CoordinatesSummator;
use App\Domain\MovableInterface;

class InterpretCommand implements CommandInterface
{
    private string $body;

    /**
     * @param $object
     */
    public function __construct(string $body)
    {
        $this->body = $body;
    }

    public function execute()
    {

    }
}