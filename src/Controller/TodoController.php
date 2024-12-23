<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        /*
         * Afficher notre tableau de todo
         * Sinon je l'initialise puis l'affiche
         * */
        if (!$session->has('todos'))
        {
            $session->set('todos', [
                'achat' => 'Acheter clé USB',
                'cours' => 'Finaliser mon cours',
                'correction' => 'Corriger mes examens'
            ]);
            $this->addFlash('info', 'Innitialisation de todo réussie');
        }
        //Si j'ai déjà un tableau de todo dans ma session, je ne fais que l'afficher

        return $this->render('todo/index.html.twig');
    }

    #[Route('/todo/add/{key}/{value}', name: 'app_todo_add')]
    public function addToDo(Request $request, $key, $value): Response
    {
        $session = $request->getSession();
        if ($session->has('todos') &&
            $session->get('todos')->contains($key))
        {
            // Message d'erreur
            $this->addFlash('error', 'Ce todo existe déjà');
        }elseif ($session->has('todos') &&
            !$session->get('todos')->contains($key))
        {
            // Créer key
            $session->get('todos')->add($key, $value);
            $this->addFlash('info', 'Valeur ajoutée avec succès');
        }else
        {
            $this->addFlash('error', 'Liste des todos non encore initialisée');
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/todo/remove/{key}/{value}', name: 'app_todo_remove')]
    public function removeFromTodo(Request $request, $key, $value): Response
    {
        $session = $request->getSession();
        if (!$session->has('todos'))
        {
            $session->set('todos', [
                'achat' => 'Acheter mon cours',
                'cours' => 'Finaliser mon cours',
                'correction' => 'Corriger mes examens'
            ]);
        }
        $todos = $session->get('todos');
        $todos->remove($key, $value);
        $session->set('todos', $todos);
        return $this->render('todo/index.html.twig');
    }
}
