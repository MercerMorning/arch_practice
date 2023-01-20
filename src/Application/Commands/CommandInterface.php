<?php

namespace App\Application\Commands;

interface CommandInterface
{
    public function execute();

    public function makeBackup();

    public function undo();
}