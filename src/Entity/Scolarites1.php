<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\Scolarites1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Scolarites1Repository::class)]
class Scolarites1
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $scolarite = null;

    #[ORM\ManyToOne(inversedBy: 'scolarites1s')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveaux $niveau = null;

    /**
     * @var Collection<int, Scolarites2>
     */
    #[ORM\OneToMany(targetEntity: Scolarites2::class, mappedBy: 'scolarite1', orphanRemoval: true)]
    private Collection $scolarites2s;

    public function __construct()
    {
        $this->scolarites2s = new ArrayCollection();
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
     * @return Collection<int, Scolarites2>
     */
    public function getScolarites2s(): Collection
    {
        return $this->scolarites2s;
    }

    public function addScolarites2(Scolarites2 $scolarites2): static
    {
        if (!$this->scolarites2s->contains($scolarites2)) {
            $this->scolarites2s->add($scolarites2);
            $scolarites2->setScolarite1($this);
        }

        return $this;
    }

    public function removeScolarites2(Scolarites2 $scolarites2): static
    {
        if ($this->scolarites2s->removeElement($scolarites2)) {
            // set the owning side to null (unless already changed)
            if ($scolarites2->getScolarite1() === $this) {
                $scolarites2->setScolarite1(null);
            }
        }

        return $this;
    }
}
