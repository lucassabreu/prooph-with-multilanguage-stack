<?php

namespace App\Action\Factories;

class CommandBusActionAwareFactory
{
    public function __invoke(\Psr\Container\ContainerInterface $container, string $requestedName)
    {
        return new $requestedName(
            $container->get('command_bus')
        );
    }
}
