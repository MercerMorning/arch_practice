<?php

namespace App\Application\Commands;

use App\Application\DTO\InterpretBodyDTO;
use App\Application\Helpers\CoordinatesSummator;
use App\Domain\MovableInterface;
use App\Infrastructure\InversionOfControlContainer;

class ObjectStartMoveCommand implements CommandInterface
{
    private MovableInterface $object;
    private InterpretBodyDTO $body;

    /**
     * @param $object
     */
    public function __construct(MovableInterface $object, InterpretBodyDTO $body)
    {
        $this->object = $object;
        $this->body = $body;
    }

    public function execute()
    {
        InversionOfControlContainer::getInstance()->resolve("Object.start.move", $this->object, $this->body);
    }
}