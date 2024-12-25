<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstController extends AbstractController
{
    #[Route('/order/{myVar}', name: 'app_myVar')]
    public function testOrderRoute($myVar) : Response
    {
        return new Response("
            <html>
                <body>
                    <h1>$myVar</h1>
                </body>
            </html>
        ");
    }
    /*Les routes les plus spécifiques doiv touj apparaître
    avant les routes les plus génériques*/
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'name' => 'MIHAN',
            'firstname' => 'Zlanca-Nto'
        ]);
    }

    //#[Route('/sayHello/{name}/{firstname}', name: 'app_sayHello')]
    public function sayHello($name, $firstname, Request $request): Response
    {
        return $this->render('first/sayHello.html.twig', [
            'name' => $name,
            'firstname' => $firstname
        ]);
    }

    #[Route('/template', name: 'app_first_template')]
    public function template() : Response
    {
        return $this->render('template.html.twig', []);
    }

    #[Route('/multiplication/{int1<\d+>}/{int2<\d+>}',
        name: 'app_multiplication',
        /*Les requirements sont des contraintes appliquées aux params
        Ici, int1 et int2 doiv être des entiers
        Nb : Site regexr.com pour la gestion des expr régulières
        requirements: ['int1' => '\d+', 'int2' => '\d+']*/
    )]
    public function multiplication($int1, int $int2): Response
    {
        $resultat = $int1 * $int2;
        return new Response("<h1>Multiplication = $resultat </h1>");
    }
}
