<?php

namespace App\Tests\Repository;

use App\Repository\SujetRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SujetRepositoryTests extends KernelTestCase
{

  public function testCount()
  {
    self::bootKernel();
    $nbSujet = self::$container->get(SujetRepository::class)->count([]);
    $this->assertEquals(1, $nbSujet);
  }
}