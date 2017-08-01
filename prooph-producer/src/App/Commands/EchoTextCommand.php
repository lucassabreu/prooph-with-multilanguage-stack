<?php

namespace App\Commands;

class EchoTextCommand extends \Prooph\Common\Messaging\Command implements \Prooph\ServiceBus\Async\AsyncMessage
{
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->init();
    }

    public function payload() : array
    {
        return [ 'text' => $this->text ];
    }

    public function getText() : string
    {
        return $this->text;
    }

    protected function setPayload(array $payload) : void
    {
        $this->text = $payload['text'];
    }
}
