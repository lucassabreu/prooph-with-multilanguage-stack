#!/bin/php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Prooph\ServiceBus\CommandBus;
use App\ServiceBus\Commands\EchoText;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;

$commandBus = new CommandBus();

$router = new CommandRouter();

//Register a callback as CommandHandler for the EchoText command
$router->route(EchoText::class)
    ->to(function (EchoText $aCommand): void {
        echo $aCommand->getText();
    });

//Expand command bus with the router plugin
$router->attachToMessageBus($commandBus);

//We create a new Command
$echoText = new EchoText('It works');

//... and dispatch it
$commandBus->dispatch($echoText);

//Output should be: It works
