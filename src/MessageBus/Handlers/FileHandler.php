<?php

namespace App\MessageBus\Handlers;

use App\MessageBus\Messages\File;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FileHandler
{
    public function __invoke(File $file)
    {
    }
}
