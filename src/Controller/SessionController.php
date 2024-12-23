<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function mysql_xdevapi\getSession;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->has('nombreVisites'))
        {
            $nombreVisites = $session->get('nombreVisites') + 1;
        }else
        {
            $nombreVisites = 1;
        }
        $session->set('nombreVisites', $nombreVisites);
        return $this->render('session/index.html.twig');
    }
}
