<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use App\Service\FileUploader;
use App\Service\MailerService;
use App\Service\PdfService;
use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    /*
     * Au niveau des controllers, l'injection de dépendance
     * peut se faire directement dans le constructeur
     * ou dans les params de method
     * */

    public function __construct(
        private readonly PersonService  $personService,
        private readonly PersonRepository $personRepository,
        private readonly MailerService $mailerService
    ){}

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/edit/{id<\d+>?0}', name: 'app_person_edit')]
    public function add(Request $request,
        FileUploader $fileUploader = null,
        Person $person = null
    ): Response
    {
        if (!$person)
        {
            $person = new Person();
            $personMessage = 'Person created successfully !';
        }
        else
        {
            $personMessage = 'Person updated successfully !';
        }
        /* $person est l'image de notre formulairex */
        $formPerson = $this->createForm(PersonType::class, $person);
        $formPerson->remove('createdAt')
            ->remove('updatedAt')
        ;
        /* Mon formulaire ira traiter la requête */
        $formPerson->handleRequest($request);
        if ($formPerson->isSubmitted() && $formPerson->isValid())
        {
            /** @var UploadedFile $imageFile */
            $imageFile = $formPerson->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $person->setImage($imageFileName);
            }
            /*
             * Au cas où person n'était pas l'image de $form? on aurait fait :
             * $data = $formPerson->getData();
             * */
            //dd($request);
            $this->personService->createOrUpdateWithPerson($person);
            $this->addFlash('success', $personMessage);
            $mailMessage = $person->getFirstname().' '.$person->getName().' '.$personMessage;
            $this->mailerService->sendEmail(to: 'mihanzlancanto@gmail.com',
                subject: $mailMessage
            );
            return $this->redirectToRoute('app_person_all');
        }else
        {
            return $this->render('person/add-person.html.twig', [
                'formPerson' => $formPerson->createView()
            ]);
        }
    }
    
    #[Route('/pdf/{id<\d+>}', name: 'app_person_pdf')]
    public function generatePdf(PdfService $pdfService,
        Person $person = null
    ): void
    {
        $html = $this->renderView('person/person-by-id.html.twig', [
            'person' => $person
        ]);
        $pdfService->showPdfFile($html);
    }

    #[Route('/delete/{id<\d+>}', name: 'app_person_delete')]
    public function delete(Person $person = null): RedirectResponse
    {
        if (!$person)
        {
            $this->addFlash('error', "Impossible d'effectuer cette action");
            $person->setCreatedBy($this->getUser());
        }else
        {
            $this->personService->delete($person);
            $this->addFlash('success', "Suppression effectuée avec succes");
        }
        return $this->redirectToRoute('app_person_all');
    }

    #[Route('/update/{id<\d+>}/{firstname?Zlanca}/{name?MIHAN}/{old?35}',
        name: 'app_person_update_by_uri'
    )]
    public function update($firstname,
        $name,
        $old,
        Person $person = null
    ): RedirectResponse
    {
        if (!$person)
        {
            $this->addFlash('error', "Impossible d'effectuer cette action");
        }else
        {
            $this->personService->update($firstname, $name, $old, null, $person);
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
            'persons' => $persons
        ]);
    }

    #[Route('/all/old/{oldMin<\d+>?1}/{oldMax<\d+>?100}', name: 'app_person_by_old_interval')]
    public function findByOdlInterval($oldMin, $oldMax): Response
    {
        $persons = $this->personRepository->findByOldInterval($oldMin, $oldMax);
        return $this->render('person/index.html.twig', [
            'persons' => $persons
        ]);
    }

    #[Route('/stats/old/{oldMin<\d+>?1}/{oldMax<\d+>?100}', name: 'app_person_by_stats_old_interval')]
    public function findByStatOdlInterval($oldMin, $oldMax): Response
    {
        $stats = $this->personRepository->statsByOldInterval($oldMin, $oldMax);
        //$stats[0]['avgOld'] = round($stats[0]['avgOld']);
        return $this->render('person/stats-person.html.twig', [
            'stats' => $stats[0]
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
        $nombrePersons = $this->personRepository->count();
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