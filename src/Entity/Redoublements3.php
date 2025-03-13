<?php

namespace App\Entity;

use App\Repository\Redoublements3Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Redoublements3Repository::class)]
class Redoublements3
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'redoublements3s')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Redoublements2 $redoublement2 = null;

    /**
     * @var Collection<int, Scolarites1>
     */
    #[ORM\ManyToMany(targetEntity: Scolarites1::class, inversedBy: 'redoublements3s')]
    private Collection $scolarites1;

    /**
     * @var Collection<int, Scolarites2>
     */
    #[ORM\ManyToMany(targetEntity: Scolarites2::class, inversedBy: 'redoublements3s')]
    private Collection $scolarites2;

    #[ORM\ManyToOne(inversedBy: 'redoublements3s')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveaux $niveau = null;

    public function __construct()
    {
        $this->scolarites1 = new ArrayCollection();
        $this->scolarites2 = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->niveau ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRedoublement2(): ?Redoublements2
    {
        return $this->redoublement2;
    }

    public function setRedoublement2(?Redoublements2 $redoublement2): static
    {
        $this->redoublement2 = $redoublement2;

        return $this;
    }

    /**
     * @return Collection<int, Scolarites1>
     */
    public function getScolarites1(): Collection
    {
        return $this->scolarites1;
    }

    public function addScolarites1(Scolarites1 $scolarites1): static
    {
        if (!$this->scolarites1->contains($scolarites1)) {
            $this->scolarites1->add($scolarites1);
        }

        return $this;
    }

    public function removeScolarites1(Scolarites1 $scolarites1): static
    {
        $this->scolarites1->removeElement($scolarites1);

        return $this;
    }

    /**
     * @return Collection<int, Scolarites2>
     */
    public function getScolarites2(): Collection
    {
        return $this->scolarites2;
    }

    public function addScolarites2(Scolarites2 $scolarites2): static
    {
        if (!$this->scolarites2->contains($scolarites2)) {
            $this->scolarites2->add($scolarites2);
        }

        return $this;
    }

    public function removeScolarites2(Scolarites2 $scolarites2): static
    {
        $this->scolarites2->removeElement($scolarites2);

        return $this;
    }

    public function getNiveau(): ?Niveaux
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveaux $niveaux): static
    {
        $this->niveau = $niveaux;

        return $this;
    }
}
