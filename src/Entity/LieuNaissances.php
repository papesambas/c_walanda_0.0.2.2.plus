<?php

namespace App\Entity;

use App\Entity\Trait\DesignationTrait;
use App\Repository\LieuNaissancesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LieuNaissancesRepository::class)]
class LieuNaissances
{
    use DesignationTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lieuNaissances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Communes $commune = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommune(): ?Communes
    {
        return $this->commune;
    }

    public function setCommune(?Communes $commune): static
    {
        $this->commune = $commune;

        return $this;
    }
}
