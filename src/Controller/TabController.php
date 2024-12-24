<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tab')]
class TabController extends AbstractController
{
    #[Route('/{number<\d+>?5}', name: 'app_tab')]
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

    #[Route('/users', name: 'app_tab_users')]
    public function users() : Response
    {
        $users = [
          [
              'name' => 'MIHAN',
              'firstname' => 'Zlanca-Nto',
              'old' => '11',
          ],
          [
              'name' => 'MICHAEL',
              'firstname' => 'Michael-Nto',
              'old' => '12',
          ],
          [
              'name' => 'KOFFI',
              'firstname' => 'Elichama',
              'old' => '13',
          ]
        ];
        return $this->render('tab/users.html.twig', [
            'users' => $users,
        ]);
    }
}
