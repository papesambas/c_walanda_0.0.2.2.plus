<?php

namespace App\Entity;

use App\Repository\Redoublements2Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Redoublements2Repository::class)]
class Redoublements2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'redoublements2s')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Redoublements1 $redoublement1 = null;

    /**
     * @var Collection<int, Scolarites1>
     */
    #[ORM\ManyToMany(targetEntity: Scolarites1::class, inversedBy: 'redoublements2s')]
    private Collection $scolarites1;

    /**
     * @var Collection<int, Scolarites2>
     */
    #[ORM\ManyToMany(targetEntity: Scolarites2::class, inversedBy: 'redoublements2s')]
    private Collection $scolarites2;

    /**
     * @var Collection<int, Redoublements3>
     */
    #[ORM\OneToMany(targetEntity: Redoublements3::class, mappedBy: 'redoublement2')]
    private Collection $redoublements3s;

    #[ORM\ManyToOne(inversedBy: 'redoublements2s')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveaux $niveau = null;

    public function __construct()
    {
        $this->scolarites1 = new ArrayCollection();
        $this->scolarites2 = new ArrayCollection();
        $this->redoublements3s = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->niveau ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRedoublement1(): ?Redoublements1
    {
        return $this->redoublement1;
    }

    public function setRedoublement1(?Redoublements1 $redoublement1): static
    {
        $this->redoublement1 = $redoublement1;

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

    /**
     * @return Collection<int, Redoublements3>
     */
    public function getRedoublements3s(): Collection
    {
        return $this->redoublements3s;
    }

    public function addRedoublements3(Redoublements3 $redoublements3): static
    {
        if (!$this->redoublements3s->contains($redoublements3)) {
            $this->redoublements3s->add($redoublements3);
            $redoublements3->setRedoublement2($this);
        }

        return $this;
    }

    public function removeRedoublements3(Redoublements3 $redoublements3): static
    {
        if ($this->redoublements3s->removeElement($redoublements3)) {
            // set the owning side to null (unless already changed)
            if ($redoublements3->getRedoublement2() === $this) {
                $redoublements3->setRedoublement2(null);
            }
        }

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
