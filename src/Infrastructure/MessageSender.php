<?php


namespace App\Infrastructure;

use PhpAmqpLib\Message\AMQPMessage;

class MessageSender extends AbstractMessageAction
{
    public function send(string $message)
    {
        $message = new AMQPMessage($message, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $this->channel->basic_publish($message, $this->exchange);
        $this->channel->close();
        $this->connection->close();
        return true;
    }
}