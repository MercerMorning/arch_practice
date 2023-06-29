<?php

namespace App\Infrastructure;

class Env
{
    CONST ENV_PATH = '/../../env.php';

    private $variables;

    public function __construct() {
        $this->variables = require __DIR__ . self::ENV_PATH;
    }

    public function get($variableName)
    {
        return $this->variables[$variableName];
    }
}