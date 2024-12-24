<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/todo')] // Préfixe
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        /*
         * Afficher notre tableau de todo
         * Sinon je l'initialise puis l'affiche
         * */
        if (!$session->has('todos'))
        {
            $todos = [
                'achat' => 'Acheter clé USB',
                'cours' => 'Finaliser mon cours',
                'correction' => 'Corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info', 'Initialisation de todo réussie');
        }
        //Si j'ai déjà un tableau de todo dans ma session, je ne fais que l'afficher

        return $this->render('todo/index.html.twig');
    }

    #[Route('/add/{key}/{value?Nothing}',
        name: 'app_todo_add',
        /* Valeur par défaut d'un attribut
         * Toujours commencer par la valeur la plus à droite
         * key peut avoir une val par déf que lorsque value a une val par déf
         * conclusion : un param peut avoir une val par déf que ssi tous ses
         * params de droite ont chacunes une val par déf
        defaults: ['value' => 'Nothing']*/
    )]
    public function addToDo(Request $request, $key, $value): Response
    {
        $session = $request->getSession();
        if ($session->has('todos') &&
            array_key_exists($key, $session->get('todos')) )
        {
            // Message d'erreur
            $this->addFlash('error', 'Ce todo existe déjà');
        }elseif ($session->has('todos') &&
            !array_key_exists($key, $session->get('todos')) )
        {
            // Créer key
            $todos = $session->get('todos');
            $todos[$key] = $value;
            $session->set('todos', $todos);
            $this->addFlash('success', "todo d'id $key ajouté avec succès");
        }else
        {
            $this->addFlash('error', 'Liste des todos non encore initialisée');
        }
        return $this->redirectToRoute('app_todo');
    }

    /*#[Route('/todo/remove/{key}/{value}', name: 'app_todo_remove')]
    public function removeFromTodo(Request $request, $key, $value): Response
    {
        $session = $request->getSession();
    }*/
}
