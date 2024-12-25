<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use App\service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    public function __construct(
        private readonly PersonService  $personService,
        private readonly PersonRepository $personRepository
    ){}

    #[Route('/all', name: 'app_person_all')]
    public function index(): Response
    {
        $persons = $this->personRepository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons
        ]);
    }

    #[Route('/add', name: 'app_person_add')]
    public function add(): Response
    {
        $person = $this->personService->create('Zlanca-Nto', 'MIHAN', 44);
        return $this->render('person/person.html.twig', [
            'person' => $person,
        ]);
    }
}
