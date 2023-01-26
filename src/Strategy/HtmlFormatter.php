<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 16:

namespace App\Strategy;

use App\Entity\Message;
use App\Strategy\MessageFormatterInterface;

class HtmlFormatter implements MessageFormatterInterface
{
  public function format(Message $message): string
  {
    return '<p>' . $message->getTexte() . '</p>';
  }
}