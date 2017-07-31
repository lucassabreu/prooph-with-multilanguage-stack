<?php

namespace App\ServiceBus;

class CommandBusFactory
{
    public function __invoke(\Psr\Container\ContainerInterface $container, string $requestedName)
    {
        $commandBus = new \Prooph\ServiceBus\CommandBus;
        if ($container->has($requestedName . '_router')) {
            $router = $container->get($requestedName . '_router');
            $router->attachToMessageBus($commandBus);
            return $commandBus;
        }

        $options = $container->get('config')['prooph']['service_bus'];
        if (isset($options[$requestedName]['router']['routes']) === false) {
            return $commandBus;
        }

        $routes = $options[$requestedName]['router']['routes'];
        foreach ($routes as $eventName => $handlerName) {
            $commandBus->attach($eventName, function ($event) use ($container, $handlerName) {
                return $container->get($handlerName)($event);
            });
        }

        return $commandBus;
    }
}
