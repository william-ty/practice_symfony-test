<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 15:

use App\Decorator\MessageDecorator;

class AuthorDateMessageDecorator extends MessageDecorator
{
  public function decorate(): string
  {
    return '<b>' . parent::decorate() . '</b>' . ' par ' . $this->message->getUser()->getPseudo() . 'le ' . $this->message->getDateCreation()->format('Y-m-d H:i:s');
  }
}
