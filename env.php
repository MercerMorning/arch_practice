<?php

return [
    'QUEUE_HOST' => 'rabbitmq',
    'QUEUE_PORT' => '5672',
    'QUEUE_USER' => 'admin',
    'QUEUE_PASS' => 'admin',
    'QUEUE_VHOST' => '/',
    'QUEUE_EXCHANGE' => 'bank_exchange',
    'QUEUE_CONSUMER' => 'consumer',
    'QUEUE_NAME' => 'commands',

    'AUTH_JWT_EXECUTE_URL' => 'http://192.168.0.105/api/execute'
];