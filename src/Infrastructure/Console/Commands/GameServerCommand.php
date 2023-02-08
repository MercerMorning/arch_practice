<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands;

use App\Application\CreatedCodeReceiver;
use App\Application\DTO\QueueConnectionDTO;
use App\Infrastructure\CodeGenerator;
use App\Infrastructure\InitScopeBasedIoCImplementation;
use App\Infrastructure\InversionOfControlContainer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface};
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'game:start',
)]
class GameServerCommand extends Command
{
    protected static $defaultDescription = 'Запускает игроквой сервер';

    protected function configure(): void
    {
//        $this
//            ->addArgument('a', InputArgument::OPTIONAL, 'Значение а')
//            ->addArgument('b', InputArgument::OPTIONAL, 'Значение b')
//            ->addArgument('c', InputArgument::OPTIONAL, 'Значение c');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $container = new InversionOfControlContainer();
        InversionOfControlContainer::setInstance($container);
        $init = new InitScopeBasedIoCImplementation();
        $init->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register", CodeGenerator::class, function () {
            $queueParams = [
                'host' => 'rabbitmq',
                'port' => '5672',
                'user' => 'admin',
                'pass' => 'admin',
                'vhost' => '/',
                'exhange' => 'bank_exchange',
                'queue' => 'codes',
                'consumer' => 'consumer',
                'email' => 'exmple@gmail.com',
            ];
            $amqpConnection = new QueueConnectionDTO($queueParams['host'],
                $queueParams['port'],
                $queueParams['user'],
                $queueParams['pass'],
                $queueParams['vhost']);
            return new CodeGenerator($amqpConnection, $queueParams['exhange'], $queueParams['queue']);
        })->execute();

        InversionOfControlContainer::getInstance()->resolve("IoC.Register", CreatedCodeReceiver::class, function () {
            $queueParams = [
                'host' => 'rabbitmq',
                'port' => '5672',
                'user' => 'admin',
                'pass' => 'admin',
                'vhost' => '/',
                'exhange' => 'bank_exchange',
                'queue' => 'codes',
                'consumer' => 'consumer',
                'email' => 'exmple@gmail.com',
            ];
            $amqpConnection = new QueueConnectionDTO($queueParams['host'],
                $queueParams['port'],
                $queueParams['user'],
                $queueParams['pass'],
                $queueParams['vhost']);
            return new CreatedCodeReceiver($amqpConnection, $queueParams['exhange'], $queueParams['queue'], $queueParams['consumer']);
        })->execute();

        /**
         * @var $reciever CreatedCodeReceiver
         */
        $reciever = InversionOfControlContainer::getInstance()->resolve(CreatedCodeReceiver::class);
        $reciever->receive();
    }
}
