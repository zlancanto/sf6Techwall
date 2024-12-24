<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/twig')]
class TwigHeritageController extends AbstractController
{
    #[Route('/', name: 'app_twig_heritage')]
    public function index(): Response
    {
        return $this->render('twig_heritage/index.html.twig', [
            'controller_name' => 'TwigHeritageController',
        ]);
    }

    #[Route('/heritage', name: 'app_twig_heritage_aux')]
    public function heritage(): Response
    {
        return $this->render('heritage.html.twig');
    }
}
