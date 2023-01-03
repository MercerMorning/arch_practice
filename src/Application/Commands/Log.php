<?php

namespace App\Application\Commands;

use Monolog\{Handler\StreamHandler, Level, Logger};
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Логирует исключение
 */
class Log implements CommandInterface
{
    /** @var Throwable */
    private Throwable $exception;
    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /** @var string Имя канала */
    private const LOGGER_NAME = 'app';
    /** @var string Путь к журналам логирования */
    private const PATH_TO_LOGS = 'var/logs/app.log';
    /** @var Level Минимальный уровень для записи в журнал */
    private const LOG_LEVEL = Level::Info;

    /**
     * @param Throwable $exception
     */
    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
        // создание канала логирования
        $this->logger = new Logger(self::LOGGER_NAME);
        $this->logger->pushHandler(new StreamHandler(self::PATH_TO_LOGS, self::LOG_LEVEL));
    }

    public function execute()
    {
        // запись в лог
        $this->logger->warning($this->exception->getMessage(), $this->exception->getTrace());
    }
}