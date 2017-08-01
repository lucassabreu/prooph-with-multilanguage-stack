<?php

return [
    'humus' => [
        'amqp' => [
            'driver' => 'amqp-extension',
            'connection' => [
                'default-amqp-connection' => [
                    'host' => 'rabbitmq',
                    'port' => 5672,
                    'login' => 'guest',
                    'password' => 'guest',
                    'vhost' => '/',
                    'persistent' => false,
                    'read_timeout' => 600,
                    'write_timeout' => 1,
                    'heartbeat' => 300,
                ],
            ],
            'exchange' => [
                'command_bus_exchange' => [
                    'name' => 'command_bus_exchange',
                    'type' => 'topic',
                    'connection' => 'default-amqp-connection',
                ],
                'event_bus_exchange' => [
                    'name' => 'event_bus_exchange',
                    'type' => 'topic',
                    'connection' => 'default-amqp-connection',
                ],
            ],
            'producer' => [
                'command_producer' => [
                    'type' => 'json',
                    'exchange' => 'command_bus_exchange',
                ],
                'event_producer' => [
                    'type' => 'json',
                    'exchange' => 'event_bus_exchange',
                ],
            ],
        ],
    ],
    'prooph' => [
        'humus-amqp-producer' => [
            'message_producer' => [
                'command_producer' => [ 'producer' => 'humus_command_producer' ],
                'event_producer' => [ 'producer' => 'humus_event_producer' ],
            ]
        ],
    ],
    'dependencies' => [
        'factories' => [
            \Humus\Amqp\Driver\Driver::class => \Humus\Amqp\Container\DriverFactory::class,
            'default-amqp-connection' => [ \Humus\Amqp\Container\ConnectionFactory::class, 'default-amqp-connection' ],

            'humus_command_producer' => [ \Humus\Amqp\Container\ProducerFactory::class, 'command_producer' ],
            'humus_event_producer' => [ \Humus\Amqp\Container\ProducerFactory::class, 'event_producer' ],

            'humus_command_message_producer' => [ \Prooph\ServiceBus\Message\HumusAmqp\Container\AmqpMessageProducerFactory::class, 'command_producer' ],
            'humus_event_message_producer' => [ \Prooph\ServiceBus\Message\HumusAmqp\Container\AmqpMessageProducerFactory::class, 'event_producer' ],
        ],
    ],
];
