<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

class BurnFuelException extends \Exception
{
    public function __construct($message = 'No fuel', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
