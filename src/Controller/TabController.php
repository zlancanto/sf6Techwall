<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{number<\d+>?5}', name: 'app_tab')]
    public function index($number): Response
    {
        $array = [];
        for ($i = 1; $i <= $number; $i++)
        {
            $array[$i] = rand(1, 100);
        }
        return $this->render('tab/index.html.twig', [
            'array' => $array,
        ]);
    }
}
