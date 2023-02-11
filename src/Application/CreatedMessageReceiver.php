<?php
namespace App\Application;



use App\Application\DTO\QueueConnectionDTO;
use App\Infrastructure\AbstractMessageAction;

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
        $this->channel->basic_consume($this->queue, $this->consumer, false, false, false, false, function ($message) {
            echo $this->makeMessageBody($message->body);

            $message->ack();
        });
        register_shutdown_function(function ($channel, $connection) {
            $channel->close();
            $connection->close();
        }, $this->channel, $this->connection);
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    private function makeMessageBody($messageBody)
    {
        return '\n--------\n' . $messageBody . '\n--------\n';
    }
}