<?php

namespace App\Controller;

use App\service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    public function __construct(
        private readonly PersonService  $personService
    ){}

    #[Route('/add', name: 'app_person_add')]
    public function add(): Response
    {
        $person = $this->personService->create('Zlanca-Nto', 'MIHAN', 44);
        return $this->render('person/index.html.twig', [
            'person' => $person,
        ]);
    }
}
