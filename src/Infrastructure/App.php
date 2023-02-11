<?php

namespace App\Infrastructure;

use App\Application\Commands\Move;
use App\Application\Commands\ObjectStartMoveCommand;
use App\Application\CreatedMessageReceiver;
use App\Application\DTO\InterpretBodyDTO;
use App\Application\DTO\QueueConnectionDTO;
use App\Domain\Coordinate;
use App\Domain\MovableInterface;
use App\Infrastructure\Commands\ReceiveCommand;
use App\Infrastructure\Env;
use App\Infrastructure\Exceptions\CommandExceptionHandler;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorage;

class App
{
    private static $instances = [];
    private $container;
    private $console;

    protected function __construct()
    {
        $this->console = false;
        $this->registerBaseServiceProviders();
    }

    public function inConsole()
    {
        $this->console = true;
        return $this;
    }

    public static function getInstance(): self
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function initialize()
    {
        if ($this->console) {
            $reciever = InversionOfControlContainer::getInstance()->resolve(CreatedMessageReceiver::class);
            $reciever->receive();
        }
        $router = InversionOfControlContainer::getInstance()->resolve(Route::class);
        return $router->contentToRender();
    }

    private function registerBaseServiceProviders(): void
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $init = new InitScopeBasedIoCImplementation();
        $init->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register","Object.start.move", function (array $arguments){
            /**
             * @var $object MovableInterface
             */
            $object = $arguments[0];
            /**
             * @var $body InterpretBodyDTO
             */
            $body = $arguments[1];
            $object->setVelocity(new Coordinate($body->getOperataionArguments()['velocity'], $body->getOperataionArguments()['velocity']));
            $moveCommand = new Move($object);
            $moveCommand->execute();
        })->execute();


        InversionOfControlContainer::getInstance()->resolve("IoC.Register",ObjectStartMoveCommand::class, function (array $arguments){
            return new ObjectStartMoveCommand($arguments[0], $arguments[1]);
        })->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register",QueueListener::class, function (array $arguments){
            return new QueueListener(new QueueStorage(), new CommandExceptionHandler());
        })->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register", Move::class, function (array $arguments){
            return new Move($arguments[0]);
        })->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register", Route::class, function () {
            return new Route();
        })->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register", Env::class, function () {
            return new Env();
        })->execute();

        /**
         * @var $env Env
         */
        $env = InversionOfControlContainer::getInstance()->resolve(Env::class);

        InversionOfControlContainer::getInstance()->resolve("IoC.Register", MessageSender::class, function () use ($env){
            $amqpConnection = new QueueConnectionDTO($env->get('QUEUE_HOST'),
                $env->get('QUEUE_PORT'),
                $env->get('QUEUE_USER'),
                $env->get('QUEUE_PASS'),
                $env->get('QUEUE_VHOST'));
            return new MessageSender($amqpConnection, $env->get('QUEUE_EXCHANGE'), $env->get('QUEUE_NAME'));
        })->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register", CreatedMessageReceiver::class, function () use ($env){
            $amqpConnection = new QueueConnectionDTO($env->get('QUEUE_HOST'),
                $env->get('QUEUE_PORT'),
                $env->get('QUEUE_USER'),
                $env->get('QUEUE_PASS'),
                $env->get('QUEUE_VHOST'));
            return new CreatedMessageReceiver($amqpConnection, $env->get('QUEUE_EXCHANGE'), $env->get('QUEUE_NAME'), $env->get('QUEUE_CONSUMER'));
        })->execute();
    }
}