<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 15:

namespace App\Decorator;

use App\Decorator\MessageDecoratorInterface;
use App\Entity\Message;

class MessageDecorator implements MessageDecoratorInterface
{
  protected $message;

  public function __construct(Message $message)
  {
    $this->message = $message;
  }

  public function decorate(): string
  {
    return $this->message->getTexte();
  }
}