<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 16:

namespace App\Strategy;

use App\Entity\Message;
use App\Strategy\MessageFormatterInterface;

class PlainTextFormatter implements MessageFormatterInterface
{
  public function format(Message $message): string
  {
    return $message->getTexte();
  }
}