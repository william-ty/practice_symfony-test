<?php

namespace App\Service;

use App\Entity\Message;
use App\Strategy\MessageFormatterInterface;

// ! REFERENCE REPONSE TEST TECHNIQUE - 17 (& 16):

class MessageFormatterService implements MessageFormatterInterface
{
  public function format(Message $message): string
  {
    return 'Utilisateur [' . $message->getUser() . '] - Message: ' . $message->getTexte();
  }
}