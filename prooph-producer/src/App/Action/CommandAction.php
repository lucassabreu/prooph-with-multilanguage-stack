<?php

namespace App\Action;

use Zend\Diactoros\Response\JsonResponse;

class CommandAction implements \Interop\Http\ServerMiddleware\MiddlewareInterface
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
        $this->commandBus->dispatch($request->getParsedBody());
        return new JsonResponse($request->getParsedBody(), 200);
    }
}
