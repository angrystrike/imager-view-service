<?php

namespace App\Controller;

use App\MessageBus\Messages\File;
use Pusher\Pusher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    private string $shared_dir;
    private Filesystem $file_system;
    private Pusher $pusher;

    public function __construct(Filesystem $file_system, Pusher $pusher)
    {
        $this->shared_dir = '/var/www/shared-data';
        $this->file_system = $file_system;
        $this->pusher = $pusher;
    }

    #[Route('/images', methods: ['GET'])]
    public function images()
    {
        $client = HttpClient::create();

        $response = $client->request('GET', 'http://nginx:82/images');

        return $this->render('images/list.html.twig', [
            'images' => $response->toArray(),
        ]);
    }

    #[Route('/', methods: ['GET'])]
    public function index()
    {
        return $this->render('index.html.twig', []);
    }

    #[Route('/upload', methods: ['POST'])]
    public function upload(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $this->pusher->trigger('file-upload-info', 'file-received', [
            'text' => 'view-service BE: File received',
        ]);

        $uploaded_file = $request->files->get('image');

        $new_filename = uniqid() . '.' . $uploaded_file->guessExtension();

        $this->file_system->mkdir($this->shared_dir);
        $uploaded_file->move(
            $this->shared_dir,
            $new_filename
        );

        $this->pusher->trigger('file-upload-info', 'file-uploaded-to-tmp', [
            'text' => 'view-service BE: File uploaded to shared folder and sent message to RabbitMQ'
        ]);

        $bus->dispatch(new File($new_filename));

        return new JsonResponse([
            'message' => 'Image uploaded successfully!',
            'filename' => $new_filename,
            'path' => '/shared-data/' . $new_filename
        ]);
    }
}
