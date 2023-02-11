<?php

namespace App\Infrastructure;

use App\Application\CreatedMessageReceiver;
use App\Application\DTO\QueueConnectionDTO;
use App\Infrastructure\Commands\ReceiveCommand;
use App\Infrastructure\Env;

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