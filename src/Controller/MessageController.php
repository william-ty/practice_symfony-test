<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Entity\Message;
use App\Form\MessageFormType;
use App\Service\LoggerService;
use App\Service\MessageFormatterService;
use App\Strategy\HtmlFormatter;
use Doctrine\Persistence\ManagerRegistry;
use App\Decorator\AuthorDateMessageDecorator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class MessageController extends AbstractController
{

    // ! REFERENCE REPONSE TEST TECHNIQUE - 16:
    private $formatter;

    public function __construct(HtmlFormatter $formatter) {
        $this->formatter = $formatter;
    }
    //
    

    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    // ! REFERENCE REPONSE TEST TECHNIQUE - 15, 16:
    #[Route('/message/{id}', name: 'message_show')]
    public function showMessage(Request $request, Message $message, ManagerRegistry $doctrine)
    {
        
        //! 15 - Decorator
        // $decorator = new BoldMessageDecorator($message);
        $decorator = new AuthorDateMessageDecorator($message);
        $decoratedMessage = $decorator->decorate();

        // //! 16 - Strategy
        // $formattedMessage = $this->formatter->format($message);
        $formattedMessage = $this->formatter->format($message);


        return $this->render('message/show.html.twig', [
            'decoratedMessage' => $decoratedMessage,
            'formattedMessage' => $formattedMessage,
            'message' => $message,
        ]);
    }

    // #[Route("/message/{id}/edit", name: "message_edit")]
    // ! REFERENCE REPONSE TEST TECHNIQUE - 2:
    /**
     * @Route("/message/{id}/edit",
     * name="message_edit",
     * requirements={"id"="\d+"}
     * )
     */
    public function editMessage(Request $request, Message $message, ManagerRegistry $doctrine, LoggerService $loggerService)
    {
        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $message->setSujet($message->getSujet());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
            
            // ! REFERENCE REPONSE TEST TECHNIQUE - 4:
            // Logger l'edition du message
            // Remarque: l'utilisateur est récupéré au niveau du service avec la classe Security.
            $loggerService->logEditMessage($message);
            
            return $this->redirectToRoute('sujet_show', ['id' => $message->getSujet()->getId()]);
            
        }


        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'messageForm' => $form->createView()
        ]);
    }

    #[Route("/message/{id}/delete", name: "message_delete")]
    public function deleteMessage(Message $message = null, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($message);
        $entityManager->flush();

        return $this->redirectToRoute('sujet_show', ['id' => $message->getSujet()->getId()]);
    }
}