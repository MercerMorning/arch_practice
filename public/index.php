<?php

use App\Application\DTO\QueueConnectionDTO;
use App\Infrastructure\CodeGenerator;
use App\Infrastructure\Exceptions\ExceptionHandlerInterface;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueListener;
use App\Infrastructure\Queue\QueueStorageInterface;

require_once('../vendor/autoload.php');

$container = new InversionOfControlContainer();
InversionOfControlContainer::setInstance($container);
$init = new \App\Infrastructure\InitScopeBasedIoCImplementation();
$init->execute();

InversionOfControlContainer::getInstance()->resolve("IoC.Register", \App\Infrastructure\CodeGenerator::class, function () {
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


$router = new \App\Infrastructure\Route();
$router::contentToRender();