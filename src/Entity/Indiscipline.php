<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\IndisciplineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndisciplineRepository::class)]
class Indiscipline
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

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isSanction = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sanction = null;

    #[ORM\ManyToOne(inversedBy: 'indisciplines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleves $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'indisciplines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeScolaires $anneeScolaire = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isSanction(): ?bool
    {
        return $this->isSanction;
    }

    public function setIsSanction(bool $isSanction): static
    {
        $this->isSanction = $isSanction;

        return $this;
    }

    public function getSanction(): ?string
    {
        return $this->sanction;
    }

    public function setSanction(?string $sanction): static
    {
        $this->sanction = $sanction;

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
}
