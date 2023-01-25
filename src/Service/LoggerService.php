<?php

namespace App\Service;

// use App\Entity\User;
use App\Entity\Message;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

// https://symfony.com/doc/current/components/console/logger.html

/**
 * Cette classe est un service de journalisation
 */
class LoggerService
{
  private $logger;
  private $security;

  public function __construct(LoggerInterface $logger, Security $security)
  {
    $this->logger = $logger;
    $this->security = $security;
  }

  // Journalisation de l'édition d'un message
  public function logEditMessage(
    Message $message, 
    // User $user
    )
  {
    // ! REFERENCE REPONSE TEST TECHNIQUE - 4:
    $user = $this->security->getUser();

    $this->logger->info('Message edited', [
      'message_id' => $message->getId(),
      'user_id' => $user->getId(),
      'message_content' => $message->getTexte()
    ]);
  }
}