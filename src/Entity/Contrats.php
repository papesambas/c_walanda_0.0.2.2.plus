<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\DesignationTrait;
use App\Repository\ContratsRepository;
use App\Entity\Trait\EntityTrackingTrait;

#[ORM\Entity(repositoryClass: ContratsRepository::class)]
class Contrats
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    use DesignationTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateSignature = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDebut = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateFin = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $particularites = null;

    #[ORM\Column]
    private ?bool $isActif = false;

    #[ORM\Column(nullable: true)]
    private ?float $tauxHoraire = null;

    #[ORM\ManyToOne(inversedBy: 'contrat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personnels $personnels = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeContrats $typeContrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSignature(): ?\DateTimeImmutable
    {
        return $this->dateSignature;
    }

    public function setDateSignature(\DateTimeImmutable $dateSignature): static
    {
        $this->dateSignature = $dateSignature;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeImmutable $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeImmutable $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getParticularites(): ?string
    {
        return $this->particularites;
    }

    public function setParticularites(?string $particularites): static
    {
        $this->particularites = $particularites;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): static
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getTauxHoraire(): ?float
    {
        return $this->tauxHoraire;
    }

    public function setTauxHoraire(?float $tauxHoraire): static
    {
        $this->tauxHoraire = $tauxHoraire;

        return $this;
    }

    public function getPersonnels(): ?Personnels
    {
        return $this->personnels;
    }

    public function setPersonnels(?Personnels $personnels): static
    {
        $this->personnels = $personnels;

        return $this;
    }

    public function getTypeContrat(): ?TypeContrats
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(?TypeContrats $typeContrat): static
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }
}
