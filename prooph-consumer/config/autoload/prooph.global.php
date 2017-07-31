<?php

use Prooph\ServiceBus;

return [
    'prooph' => [
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                        \App\ServiceBus\Commands\EchoText::class => \App\ServiceBus\CommandHandlers\EchoTextHandler::class,
                    ],
                ],
            ],
        ],
    ],
    'dependencies' => [
        'aliases' => [
            ServiceBus\CommandBus::class => 'command_bus',
        ],
        'invokables' => [
            \App\ServiceBus\CommandHandlers\EchoTextHandler::class => \App\ServiceBus\CommandHandlers\EchoTextHandler::class,
        ],
        'factories' => [
            \App\Action\EchoTextAction::class => \App\Action\Factories\CommandBusActionAwareFactory::class,
            'command_bus' => \App\ServiceBus\CommandBusFactory::class,
            'command_bus_router' => \App\ServiceBus\CommandRouterFactory::class,
        ],
    ],
];
