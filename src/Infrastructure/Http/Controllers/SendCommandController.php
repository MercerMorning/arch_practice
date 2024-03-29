<?php

namespace App\Infrastructure\Http\Controllers;


use App\Infrastructure\Env;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\MessageSender;
use GuzzleHttp\Client;

class SendCommandController
{
    private MessageSender $codeGeneratorService;
    private Client $client;
    private Env $env;

    public function __construct()
    {
        $this->client = InversionOfControlContainer::getInstance()->resolve(Client::class);
        $this->env = InversionOfControlContainer::getInstance()->resolve(Env::class);
        $this->codeGeneratorService = InversionOfControlContainer::getInstance()->resolve(MessageSender::class);
    }

    public function index()
    {
        $bearerToken = $_SERVER['HTTP_AUTHORIZATION'];
        $body = [
            'game_id' => $_POST['game_id'],
            'object_id' => $_POST['object_id'],
            'operation_id' => $_POST['operation_id'],
            'operation_arguments' => $_POST['operation_arguments'],
        ];
        $request = $this->client->request('post', $this->env->get('AUTH_JWT_EXECUTE_URL'), [
            'battle' => $body['game_id'],
            'headers' => [
                [
                    'Authorization' => $bearerToken
                ]
            ]
        ]);
        if ($request->getStatusCode() == 200) {
            $this->codeGeneratorService->send(json_encode($body));
            echo 'OK';
        } else {
            echo 'FAIL';
        }

    }
}