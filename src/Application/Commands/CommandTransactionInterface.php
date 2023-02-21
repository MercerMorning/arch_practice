<?php

namespace App\Application\Commands;

interface CommandTransactionInterface
{
    public function makeBackup();

    public function undo();
}