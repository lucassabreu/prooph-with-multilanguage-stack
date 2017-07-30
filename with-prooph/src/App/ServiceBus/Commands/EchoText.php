<?php

namespace App\ServiceBus\Commands;

class EchoText implements \Prooph\Common\Messaging\HasMessageName
{
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function messageName() : string
    {
        return self::class;
    }
}
