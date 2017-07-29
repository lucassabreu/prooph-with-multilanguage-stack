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
                'command_bus_error_exchange' => [
                    'name' => 'command_bus_error_exchange',
                    'type' => 'topic',
                    'connection' => 'default-amqp-connection',
                ],
                'delayed_command_bus_exchange' => [
                    'name' => 'delayed_command_bus_exchange',
                    'type' => 'x-delayed-message',
                    'arguments' => [
                        'x-delayed-type' => 'topic'
                    ],
                    'connection' => 'default-amqp-connection',
                ],
            ],
            'queue' => [
                'command_bus_error_queue' => [
                    'name' => 'command_bus_error_queue',
                    'exchanges' => [
                        'command_bus_error_exchange' => [
                            [
                                'routing_keys' => [
                                    '#'
                                ],
                            ],
                        ],
                    ],
                    'connection' => 'default-amqp-connection',
                ],
                'command_bus_queue' => [
                    'name' => 'command_bus_queue',
                    'exchanges' => [
                        'command_bus_exchange' => [
                            [
                                'routing_keys' => [
                                    '#'
                                ],
                            ],
                        ],
                        'delayed_command_bus_exchange' => [
                            [
                                'routing_keys' => [
                                    '#'
                                ],
                            ],
                        ],
                    ],
                    'arguments' => [
                        'x-dead-letter-exchange' => 'command_bus_error_exchange',
                    ],
                    'connection' => 'default-amqp-connection',
                ],
            ],
            'callback_consumer' => [
                'command_consumer' => [
                    'queue' => 'command_bus_queue',
                    'delivery_callback' => 'command_consumer_callback',
                    'idle_timeout' => 3,
                    'qos'          => [
                        'prefetch_count' => 2
                    ],
                    'logger' => null,
                ],
            ],
        ],
    ],
    'prooph' => [
        'humus-amqp-producer' => [
            'command_consumer_callback' => [
                'command_consumer_callback' => [
                    'command_bus' => 'command_bus',
                    'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
                ],
            ],
        ],
        'service_bus' => [
            'command_bus' => [
                // command bus settings, all or at least some commands are send to the amqp_command_bus
            ],
        ],
    ],
    'dependencies' => [
		'factories' => [
			\Humus\Amqp\Driver\Driver::class => \Humus\Amqp\Container\DriverFactory::class,
            'default-amqp-connection' => [
                \Humus\Amqp\Container\ConnectionFactory::class,
                'default-amqp-connection'
            ],
            'command_consumer' => [
                \Humus\Amqp\Container\CallbackConsumerFactory::class,
                'command_consumer'
            ],
            'command_consumer_callback' => [
                \Prooph\ServiceBus\Message\HumusAmqp\Container\AmqpCommandConsumerCallbackFactory::class,
                'command_consumer_callback'
            ],
        ],
    ],
];
