<?php

namespace App\Entity;

use App\Repository\SantesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SantesRepository::class)]
class Santes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 130)]
    private ?string $maladie = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $medecin = null;

    #[ORM\Column(length: 25)]
    private ?string $numeroUrgence = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $centreSante = null;

    #[ORM\ManyToOne(inversedBy: 'santes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleves $eleve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaladie(): ?string
    {
        return $this->maladie;
    }

    public function setMaladie(string $maladie): static
    {
        $this->maladie = $maladie;

        return $this;
    }

    public function getMedecin(): ?string
    {
        return $this->medecin;
    }

    public function setMedecin(?string $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getNumeroUrgence(): ?string
    {
        return $this->numeroUrgence;
    }

    public function setNumeroUrgence(string $numeroUrgence): static
    {
        $this->numeroUrgence = $numeroUrgence;

        return $this;
    }

    public function getCentreSante(): ?string
    {
        return $this->centreSante;
    }

    public function setCentreSante(?string $centreSante): static
    {
        $this->centreSante = $centreSante;

        return $this;
    }

    public function getEleve(): ?Eleves
    {
        return $this->eleve;
    }

    public function setEleve(?Eleves $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }
}
