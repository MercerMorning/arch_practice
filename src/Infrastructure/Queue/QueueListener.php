<?php

namespace App\Infrastructure\Queue;

use App\Infrastructure\Exceptions\CommandHandlerInterface;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\Statements\Common;
use App\Infrastructure\Queue\Statements\Finished;
use App\Infrastructure\Queue\Statements\MoveTo;
use App\Infrastructure\Queue\Statements\StatementInterface;
use \Exception;

class QueueListener
{
    private StatementInterface $statement;
    private QueueStorageInterface $queueStorage;
    public ExceptionHandlerInterface $errorHandler;

    public function __construct(QueueStorageInterface $queueStorage, ExceptionHandlerInterface $errorHandler)
    {
        $this->statement = InversionOfControlContainer::getInstance()->resolve('QueryListener.CommonStatement');
        $this->queueStorage = $queueStorage;
        $this->errorHandler = $errorHandler;
    }

    public function listen(): void
    {
        while ($statement = $this->statement->handle($this->queueStorage, $this->errorHandler)) {
            $this->statement = $statement;
        }
    }

    public function finish()
    {
        $this->statement = InversionOfControlContainer::getInstance()->resolve('QueryListener.FinishedStatement');
    }

    public function moveToAnotherQueue()
    {
        $this->statement = InversionOfControlContainer::getInstance()->resolve('QueryListener.MoveToStatement');
    }

    public function getStatement() {
        return $this->statement;
    }
}