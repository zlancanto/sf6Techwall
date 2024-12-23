<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'name' => 'MIHAN',
            'firstname' => 'Zlanca-Nto'
        ]);
    }

    #[Route('/sayHello/{name}', name: 'app_sayHello')]
    public function sayHello($name, Request $request): Response
    {
        dd($request);
        return $this->render('first/sayHello.html.twig', [
            'name' => $name
        ]);
    }
}
