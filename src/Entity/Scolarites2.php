<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\Scolarites2Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Scolarites2Repository::class)]
class Scolarites2
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $scolarite = null;

    #[ORM\ManyToOne(inversedBy: 'scolarites2s')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Scolarites1 $scolarite1 = null;

    #[ORM\ManyToOne(inversedBy: 'scolarites2s')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveaux $niveau = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScolarite(): ?int
    {
        return $this->scolarite;
    }

    public function setScolarite(int $scolarite): static
    {
        $this->scolarite = $scolarite;

        return $this;
    }

    public function getScolarite1(): ?Scolarites1
    {
        return $this->scolarite1;
    }

    public function setScolarite1(?Scolarites1 $scolarite1): static
    {
        $this->scolarite1 = $scolarite1;

        return $this;
    }

    public function getNiveau(): ?Niveaux
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveaux $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }
}
