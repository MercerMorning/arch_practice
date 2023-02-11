<?php

namespace App\Application\Commands;

use App\Application\DTO\InterpretBodyDTO;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueStorage;

class InterpretCommand implements CommandInterface
{
    private InterpretBodyDTO $body;

    const OPERATIONS = [
        1 => Move::class
    ];

    /**
     * @param $object
     */
    public function __construct(string $body)
    {
        $body = json_decode($body, 1);
        $this->body = new InterpretBodyDTO($body['game_id'], $body['object_id'], $body['operation_id']);
    }

    public function execute()
    {
        $object = InversionOfControlContainer::getInstance()->resolve(
            "game." . $this->body->getGameId() . ".object." . $this->body->getObjectId()
        );
        $command = new (self::OPERATIONS[$this->body->getOperationId()])($object);
        QueueStorage::push($command);
    }
}