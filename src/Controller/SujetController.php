<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Entity\Message;
use App\Form\MessageFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('forum/sujets')]
class SujetController extends AbstractController
{
    #[Route('/', name: 'sujets')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $sujets = $doctrine->getRepository(Sujet::class)->getAll();

        return $this->render('sujet/index.html.twig', [
            'controller_name' => 'SujetController',
            'sujets' => $sujets
        ]);
    }

    // ! REFERENCE REPONSE TEST TECHNIQUE - 10:
    #[Route('/add', name: 'sujet_add')]
    #[Route('/{id}/edit', name: 'sujet_edit')]
    public function addEditSujet(Request $request, Sujet $sujet = null, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $entityManager = $doctrine->getManager();

        if (!$sujet) {
            $sujet = new Sujet();
        }

        $form = $this->createFormBuilder($sujet)
            ->add('titre', TextType::class)
            ->add('Valider', SubmitType::class)
            ->getForm();
        // Ou avec le FormType (php bin/console make:form)
        // $form = $this->createForm(SujetFormType::class, $sujet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Penser à ajouter une méthode __toString() à User
            $sujet->setUser($user);

            $entityManager->persist($sujet);
            $entityManager->flush();

            return $this->redirectToRoute('sujets');
        }

        return $this->render('sujet/add_edit.html.twig', [
            'sujetForm' => $form->createView(),
            'editMode' => $sujet->getId() !== null
        ]);
    }


    #[Route('/{id}', name: 'sujet_show')]
    // #[Route('/{id}/message/add', name: 'messages_add')] // à utiliser si une méthode et une vue séparée 
    public function showSujetAddMessage(Request $request, Sujet $sujet, Message $message = null, ManagerRegistry $doctrine)
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $message = new Message();

        // A utiliser avec un make:form (FormType)
        $form = $this->createForm(MessageFormType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = $form->getData();

            // Ajouter au message le sujet dont l'id est dans la requête
            $message->setSujet($sujet);
            // Assigner au message l'utilisateur en session
            $message->setUser($user);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('sujet_show', ['id' => $sujet->getId()]);
        }

        return $this->render('sujet/show.html.twig', [
            'sujet' => $sujet,
            'messageForm' => $form->createView()
        ]);
    }


    #[Route('/{id}/verrouille', name: 'sujet_verrouille')]
    public function verrouillerSujet(Sujet $sujet, ManagerRegistry $doctrine)
    {
        // verrouiller un sujet
        $entityManager = $doctrine->getManager();

        if (!$sujet->isVerrouille()) {
            $sujet->setVerrouille(true);
        } else {
            $sujet->setVerrouille(false);
        }
        $entityManager->flush();
        // rediriger vers la vue du sujet
        return $this->redirectToRoute("sujets");

    }

    #[Route('/{id}/delete', name: 'sujet_delete')]
    public function deleteSujet(Sujet $sujet = null, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($sujet);
        $entityManager->flush();

        return $this->redirectToRoute('sujets');
    }
}