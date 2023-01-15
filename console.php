<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Console\Commands\MoveCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new MoveCommand());

$application->run();
