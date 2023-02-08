<?php

namespace App\Infrastructure\Http\Controllers;


use App\Infrastructure\CodeGenerator;
use App\Infrastructure\InversionOfControlContainer;

class SendCommandController
{
    private $codeGeneratorService;

    public function __construct()
    {
        $this->codeGeneratorService = InversionOfControlContainer::getInstance()->resolve(CodeGenerator::class);
    }

    public function index() {
        echo $this->codeGeneratorService->sendGeneratedCode() ? 'code generated' : 'something went wrong';
    }
}