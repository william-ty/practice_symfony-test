<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 13 & 18:

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait EntityTimeTrait
{

  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private ?\DateTimeInterface $dateCreation;

  public function __construct()
  {
    $this->setDateCreation(new \DateTime());
  }

  public function getDateCreation(): ?\DateTimeInterface
  {
    return $this->dateCreation;
  }

  public function setDateCreation(\DateTimeInterface $dateCreation): self
  {
    $this->dateCreation = $dateCreation;

    return $this;
  }

}