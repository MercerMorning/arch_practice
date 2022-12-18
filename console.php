<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Console\Commands\SolveEquationCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new SolveEquationCommand());

$application->run();
