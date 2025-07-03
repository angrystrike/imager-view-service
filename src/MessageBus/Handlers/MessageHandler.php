<?php

namespace App\MessageBus\Handlers;

use App\MessageBus\Messages\Message;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MessageHandler
{
    public function __invoke(Message $message)
    {
        dump('Received in View Service: ' . $message->content);
    }
}
