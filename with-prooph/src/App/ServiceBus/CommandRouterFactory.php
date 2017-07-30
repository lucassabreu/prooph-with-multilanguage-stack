<?php

namespace App\ServiceBus;

class CommandRouterFactory
{
    public function __invoke(\Psr\Container\ContainerInterface $container, string $requestedName)
    {
        $router = new \Prooph\ServiceBus\Plugin\Router\CommandRouter;

        $commandBusName = substr($requestedName, 0, strlen($requestedName) - 7);
        $options = $container->get('config')['prooph']['service_bus'];
        if (isset($options[$commandBusName]['router']['routes']) === false) {
            return $router;
        }

        $routes = $options[$commandBusName]['router']['routes'];
        foreach ($routes as $eventName => $handlerName) {
            $router
                ->route($eventName)
                ->to(function ($event) use ($container, $handlerName) {
                    return $container->get($handlerName)($event);
                });
        }

        return $router;
    }
}
