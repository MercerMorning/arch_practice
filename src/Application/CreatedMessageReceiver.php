<?php
namespace App\Application;



use App\Application\Commands\InterpretCommand;
use App\Application\DTO\QueueConnectionDTO;
use App\Infrastructure\AbstractMessageAction;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorage;

class CreatedMessageReceiver extends AbstractMessageAction
{
    private $consumer;

    public function __construct(QueueConnectionDTO $connection, $exchange, $queue, $consumer)
    {
        parent::__construct($connection, $exchange, $queue);
        $this->consumer = $consumer;
    }

    public function receive()
    {
        $listener = InversionOfControlContainer::getInstance()->resolve(QueueListener::class);
        $this->channel->basic_consume($this->queue, $this->consumer, false, false, false, false, function ($message) {
            QueueStorage::push(new InterpretCommand($message->body));
            echo $message->body . PHP_EOL;
            $message->ack();
        });

        register_shutdown_function(function ($channel, $connection) {
            $channel->close();
            $connection->close();
        }, $this->channel, $this->connection);
        while ($this->channel->is_consuming()) {
            $listener->listen();
            $this->channel->wait();
        }
    }
}