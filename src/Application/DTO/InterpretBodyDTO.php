<?php

namespace App\Application\DTO;

class InterpretBodyDTO
{
    private string $gameId;

    private string $objectId;
    private string $operationId;
    private array $operataionArguments;

    /**
     * @param string $gameId
     * @param string $objectId
     * @param string $operationId
     * @param array|null $opertaionArguments
     */
    public function __construct(string $gameId, string $objectId, string $operationId, array $operataionArguments = [])
    {
        $this->gameId = $gameId;
        $this->objectId = $objectId;
        $this->operationId = $operationId;
        $this->operataionArguments = $operataionArguments;
    }

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

    /**
     * @return array|null
     */
    public function getOperataionArguments(): ?array
    {
        return $this->operataionArguments;
    }


}