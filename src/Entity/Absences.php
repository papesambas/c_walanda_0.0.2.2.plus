<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\AbsencesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbsencesRepository::class)]
class Absences
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $jour = null;

    #[ORM\Column]
    private ?bool $isJustify = false;

    #[ORM\Column(length: 130, nullable: true)]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleves $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeScolaires $anneeScolaire = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $heure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?\DateTimeImmutable
    {
        return $this->jour;
    }

    public function setJour(\DateTimeImmutable $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function isJustify(): ?bool
    {
        return $this->isJustify;
    }

    public function setIsJustify(bool $isJustify): static
    {
        $this->isJustify = $isJustify;

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

    public function getEleve(): ?Eleves
    {
        return $this->eleve;
    }

    public function setEleve(?Eleves $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getAnneeScolaire(): ?AnneeScolaires
    {
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire(?AnneeScolaires $anneeScolaire): static
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    public function getHeure(): ?\DateTimeImmutable
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeImmutable $heure): static
    {
        $this->heure = $heure;

        return $this;
    }
}
