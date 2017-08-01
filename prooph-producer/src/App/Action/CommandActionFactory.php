<?php

namespace App\Action;

class CommandActionFactory
{
    public function __invoke(\Psr\Container\ContainerInterface $container)
    {
        return new CommandAction($container->get('async_command_bus'));
    }
}
