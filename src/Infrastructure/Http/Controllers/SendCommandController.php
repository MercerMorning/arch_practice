<?php

namespace App\Infrastructure\Http\Controllers;


use App\Infrastructure\MessageSender;
use App\Infrastructure\InversionOfControlContainer;

class SendCommandController
{
    private MessageSender $codeGeneratorService;

    public function __construct()
    {
        $this->codeGeneratorService = InversionOfControlContainer::getInstance()->resolve(MessageSender::class);
    }

    public function index() {
        $body = [
            'game_id' => $_POST['game_id'],
            'object_id' => $_POST['object_id'],
            'operation_id' => $_POST['operation_id'],
        ];
        $this->codeGeneratorService->send(json_encode($body));
        echo 'OK';
    }
}