<?php

namespace App\Application\Commands;

use App\Application\Helpers\CoordinatesSummator;
use App\Domain\MovableInterface;
use App\Domain\MovableSnapshot;

class Move implements CommandInterface, CommandTransactionInterface
{
    private MovableInterface $object;
    private MovableSnapshot $backup;

    /**
     * @param $object
     */
    public function __construct(MovableInterface $object)
    {
        $this->object = $object;
    }

    public function execute()
    {
        $this->object->setPosition(
            CoordinatesSummator::makeSum($this->object->getPosition(), $this->object->getVelocity())
        );
    }

    public function makeBackup()
    {
        $this->backup = $this->object->createSnapshot();
    }

    public function undo()
    {
        if ($this->backup !== null) {
            $this->backup->restore();
        }
    }
}