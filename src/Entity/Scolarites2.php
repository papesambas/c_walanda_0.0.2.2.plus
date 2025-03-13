<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\Scolarites2Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'scolarites2s', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: 'id',)]
    private ?Scolarites1 $scolarite1 = null;

    #[ORM\ManyToOne(inversedBy: 'scolarites2s', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: 'id',)]
    private ?Niveaux $niveau = null;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'scolarite2')]
    private Collection $eleves;

    /**
     * @var Collection<int, Redoublements1>
     */
    #[ORM\ManyToMany(targetEntity: Redoublements1::class, mappedBy: 'scolarites2')]
    private Collection $redoublements1s;

    /**
     * @var Collection<int, Redoublements2>
     */
    #[ORM\ManyToMany(targetEntity: Redoublements2::class, mappedBy: 'scolarites2')]
    private Collection $redoublements2s;

    /**
     * @var Collection<int, Redoublements3>
     */
    #[ORM\ManyToMany(targetEntity: Redoublements3::class, mappedBy: 'scolarites2')]
    private Collection $redoublements3s;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->redoublements1s = new ArrayCollection();
        $this->redoublements2s = new ArrayCollection();
        $this->redoublements3s = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->niveau ?? '';
    }


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

    /**
     * @return Collection<int, Eleves>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleves $elefe): static
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setScolarite2($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getScolarite2() === $this) {
                $elefe->setScolarite2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Redoublements1>
     */
    public function getRedoublements1s(): Collection
    {
        return $this->redoublements1s;
    }

    public function addRedoublements1(Redoublements1 $redoublements1): static
    {
        if (!$this->redoublements1s->contains($redoublements1)) {
            $this->redoublements1s->add($redoublements1);
            $redoublements1->addScolarites2($this);
        }

        return $this;
    }

    public function removeRedoublements1(Redoublements1 $redoublements1): static
    {
        if ($this->redoublements1s->removeElement($redoublements1)) {
            $redoublements1->removeScolarites2($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Redoublements2>
     */
    public function getRedoublements2s(): Collection
    {
        return $this->redoublements2s;
    }

    public function addRedoublements2(Redoublements2 $redoublements2): static
    {
        if (!$this->redoublements2s->contains($redoublements2)) {
            $this->redoublements2s->add($redoublements2);
            $redoublements2->addScolarites2($this);
        }

        return $this;
    }

    public function removeRedoublements2(Redoublements2 $redoublements2): static
    {
        if ($this->redoublements2s->removeElement($redoublements2)) {
            $redoublements2->removeScolarites2($this);
        }

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
            $redoublements3->addScolarites2($this);
        }

        return $this;
    }

    public function removeRedoublements3(Redoublements3 $redoublements3): static
    {
        if ($this->redoublements3s->removeElement($redoublements3)) {
            $redoublements3->removeScolarites2($this);
        }

        return $this;
    }
}
