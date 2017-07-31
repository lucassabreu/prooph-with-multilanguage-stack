<?php

use Humus\Amqp\Console\ConsoleRunner;

$container = require __DIR__ . '/container.php';

return ConsoleRunner::createHelperSet($container);
