<?php

namespace App\Tests\Entity;
use App\Entity\Sujet;
use PHPUnit\Framework\TestCase;

class SujetTest extends TestCase {

  public function testSetTitre() {

    $sujet = new Sujet();

    $sujet->setTitre("C'est le weekend");

    $this->assertEquals("C'est le weekend", $sujet->getTitre());

  }

}