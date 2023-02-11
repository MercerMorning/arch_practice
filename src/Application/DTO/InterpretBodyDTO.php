<?php

namespace App\Application\DTO;

class InterpretBodyDTO
{
    private string $gameId;

    /**
     * @return string
     */
    public function getGameId(): string
    {
        return $this->gameId;
    }

    /**
     * @return string
     */
    public function getObjectId(): string
    {
        return $this->objectId;
    }

    /**
     * @return string
     */
    public function getOperationId(): string
    {
        return $this->operationId;
    }
    private string $objectId;
    private string $operationId;

    /**
     * @param string $gameId
     * @param string $objectId
     * @param string $operationId
     */
    public function __construct(string $gameId, string $objectId, string $operationId)
    {
        $this->gameId = $gameId;
        $this->objectId = $objectId;
        $this->operationId = $operationId;
    }


}