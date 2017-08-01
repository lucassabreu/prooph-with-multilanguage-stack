<?php

return [
    'prooph' => [
        'service_bus' => [
            'async_command_bus' => [
                'router' => [
                    'routes' => [
                        '*' => 'humus_command_message_producer',
                    ],
                ],
            ],
            'async_event_bus' => [
                'router' => [
                    'routes' => [
                        '*' => [ 'humus_event_message_producer' ],
                    ],
                ],
            ],
        ],
    ],
    'dependencies' => [
        'invokables' => [
            \Prooph\Common\Messaging\NoOpMessageConverter::class => \Prooph\Common\Messaging\NoOpMessageConverter::class,
        ],
        'factories' => [
            'async_command_bus' => [ \Prooph\ServiceBus\Container\CommandBusFactory::class, 'async_command_bus' ],
            'async_event_bus' => [ \Prooph\ServiceBus\Container\EventBusFactory::class, 'async_event_bus' ],
        ],
    ],
];
