<?php

namespace App\ServiceBus\CommandHandlers;

class EchoTextHandler
{
    public function __invoke(\App\ServiceBus\Commands\EchoText $command)
    {
        echo $command->getText();
    }
}
