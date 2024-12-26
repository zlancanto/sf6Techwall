<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use App\service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    public function __construct(
        private readonly PersonService  $personService,
        private readonly PersonRepository $personRepository
    ){}

    #[Route('/add', name: 'app_person_add')]
    public function add(): Response
    {
        $person = $this->personService->create('Zlanca-Nto', 'MIHAN', 44);
        return $this->render('person/person.html.twig', [
            'person' => $person,
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'app_person_delete')]
    public function delete(Person $person = null): RedirectResponse
    {
        if (!$person)
        {
            $this->addFlash('error', "Impossible d'effectuer cette action");
        }else
        {
            $this->personService->delete($person);
            $this->addFlash('success', "Suppression effectuée avec succes");
        }
        return $this->redirectToRoute('app_person_all');
    }

    #[Route('/update/{id<\d+>}/{firstname?Zlanca}/{name?MIHAN}/{old?35}',
        name: 'app_person_update'
    )]
    public function update(Person $person = null, $firstname, $name, $old): RedirectResponse
    {
        if (!$person)
        {
            $this->addFlash('error', "Impossible d'effectuer cette action");
        }else
        {
            $person = $this->personService->update($firstname, $name, $old, null, $person);
            $this->addFlash('success', 'Modification effectuée avec succes');
        }
        return $this->redirectToRoute('app_person_all');
    }

    /**
        Récupère toutes les persons
     **/
    #[Route('/all', name: 'app_person_all')]
    public function index(): Response
    {
        $persons = $this->personRepository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
            'isPaginated' => false
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_person_by_id')]
    public function personById(Person $person = null
        /*
         * null pour ne pas qu'il y ait d'erreur quand il ne trouve pas l'id
         * $id sans param-converter
         * */
    ): Response
    {
        /*
         * Sans param-converter
         * $person = $this->personRepository->find($id);
         * */
        if (!$person)
        {
            /* Pour l'affichage d'une infobulle d'erreurs */
            $this->addFlash('error', 'Person not found');
            return $this->redirectToRoute('app_person_all');
        }
        return $this->render('person/person-by-id.html.twig', [
            'person' => $person
        ]);
    }

    #[Route('/all-by-criteria/{page?1}/{number?10}', name: 'app_person_by_criteria')]
    public function personByCriteria($page, $number): Response
    {
        /*$persons = $this->personRepository->findBy(['firstname' => 'aimé'],
            ['old' => 'ASC'],
            4,
            2
        );*/
        $nombrePersons = $this->personRepository->count([]);
        $nombrePages = ceil($nombrePersons / $number);
        $persons = $this->personRepository->findBy([],
            ['firstname' => 'ASC', 'name' => 'ASC'],
            $number,
            ($page-1)*$number);
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
            'nombrePages' => $nombrePages,
            'page' => $page,
            'number' => $number,
            'isPaginated' => true
        ]);
    }
}
