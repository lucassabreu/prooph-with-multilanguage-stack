<?php

namespace App\Action;

class EchoTextAction implements \Interop\Http\ServerMiddleware\MiddlewareInterface
{
    private $commandBus;

    public function __construct(\Prooph\ServiceBus\CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function process(
        \Psr\Http\Message\ServerRequestInterface $request,
        \Interop\Http\ServerMiddleware\DelegateInterface $delegate
    ) {
        $this->commandBus->dispatch(new \App\ServiceBus\Commands\EchoText('It works !'));
        return new \Zend\Diactoros\Response\Response;
    }
}
