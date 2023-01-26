<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 15:

namespace App\Decorator;

use App\Decorator\MessageDecorator;

class BoldMessageDecorator extends MessageDecorator
{
  public function decorate(): string
  {
    return '<b>' . parent::decorate() . '</b>';
  }
}

// Exemple d'utilisation : 
// $message = new Message();
// $decorator = new BoldMessageDecorator($message);
// echo $decorator->decorate();