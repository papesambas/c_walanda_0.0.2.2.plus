<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\DepartsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepartsRepository::class)]
class Departs
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateDepart = null;

    #[ORM\Column(length: 130, nullable: true)]
    private ?string $ecoleDestination = null;

    #[ORM\ManyToOne(inversedBy: 'departs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?eleves $eleve = null;

    #[ORM\Column(length: 130)]
    private ?string $motif = 'Demande des parents';

    public function __toString()
    {
        return $this->motif ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepart(): ?\DateTimeImmutable
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeImmutable $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getEcoleDestination(): ?string
    {
        return $this->ecoleDestination;
    }

    public function setEcoleDestination(?string $ecoleDestination): static
    {
        $this->ecoleDestination = $ecoleDestination;

        return $this;
    }

    public function getEleve(): ?eleves
    {
        return $this->eleve;
    }

    public function setEleve(?eleves $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }
}
