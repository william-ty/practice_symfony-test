<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 13 & 18:

namespace App\Adapter;

use Doctrine\ORM\EntityManagerInterface;

class EntityRepositoryAdapter implements EntityRepositoryInterface
{

  private $doctrine;

  public function __construct(EntityManagerInterface $doctrine)
  {
    $this->doctrine = $doctrine;
  }

  public function save($entity)
  {
    // $now = new \DateTime();
    // $entity->setDateCreation($now);
    // dd($entity);
    $this->doctrine->persist($entity);
    $this->doctrine->flush();
  }

}