<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/images', methods: ['GET'])]
    public function images()
    {
        $client = HttpClient::create();

        $response = $client->request('GET', 'http://nginx:82/images');

        return $this->render('images/list.html.twig', [
            'images' => $response->toArray(),
        ]);
    }
}
