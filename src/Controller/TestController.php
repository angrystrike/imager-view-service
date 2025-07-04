<?php
namespace App\Controller;

use App\MessageBus\Messages\Message;
use Pusher\Pusher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    private Pusher $pusher;

    public function __construct(Pusher $pusher)
    {
        $this->pusher = $pusher;
    }

    #[Route('/hello', methods: ['GET'])]
    public function hello(MessageBusInterface $bus)
    {
        // $bus->dispatch(new Message('Hello from view-service'));

        $message = [
            'text' => 'Hello from Symfony via Pusher!',
            'time' => (new \DateTimeImmutable())->format('H:i:s')
        ];

        $this->pusher->trigger('my-channel', 'my-event', $message);

        return new JsonResponse(['message' => 'HELLo1']);
    }
}
