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
        try {
            $echoText = new \Hooks\Commands\EchoText;
            $echoText->setText($request->getParsedBody()['text']);
            $this->commandBus->dispatch(new \App\Commands\EchoTextCommand(
                $echoText->serializeToString()
            ));
            return new JsonResponse([ 'success' => true ], 200);
        } catch (\Exception $e) {
            $return = [];
            do {
                $return[] = [
                    'msg' => $e->getMessage(),
                    'trace' => explode(PHP_EOL, $e->getTraceAsString()),
                ];
            } while ($e = $e->getPrevious());

            return new JsonResponse($return, 403);
        }
    }
}
