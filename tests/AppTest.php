<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{

  public function testonsLesTests()
  {
    $this->assertEquals(2, 4 / 2);
  }

}

// Pour lancer les tests, executer la commande `php bin/phpunit`


// TestCase 
// KernelTestCase - Tests fonctionnels dans un contexte d'application
// WebTestCase - Tests des controleurs 
