<?php


use App\Infrastructure\App;

require_once('../vendor/autoload.php');

$app = App::getInstance();
$app->initialize();