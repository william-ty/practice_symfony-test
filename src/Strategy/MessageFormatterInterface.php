<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 16:

namespace App\Strategy;

use App\Entity\Message;

interface MessageFormatterInterface
{
  public function format(Message $message): string;
}