<?php
namespace App\Controller;

use App\MessageBus\Messages\Message;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    #[Route('/hello', methods: ['GET'])]
    public function hello(MessageBusInterface $bus)
    {
        $bus->dispatch(new Message('Hello from view-service'));

        return new JsonResponse(['message' => 'HELLo1']);
    }
}
