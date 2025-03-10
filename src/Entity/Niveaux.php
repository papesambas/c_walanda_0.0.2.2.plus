<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\NiveauxRepository;
use App\Entity\Trait\DesignationTrait;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NiveauxRepository::class)]
class Niveaux
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'niveauxes', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id', )]
    private ?Cycles $cycle = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero()]
    private ?int $capacite = 0;

    #[ORM\Column]
    #[Assert\PositiveOrZero()]
    private ?int $effectif = 0;

    /**
     * @var Collection<int, Classes>
     */
    #[ORM\OneToMany(targetEntity: Classes::class, mappedBy: 'niveau')]
    private Collection $classes;

    /**
     * @var Collection<int, Statuts>
     */
    #[ORM\ManyToMany(targetEntity: Statuts::class, mappedBy: 'niveaux')]
    private Collection $statuts;

    /**
     * @var Collection<int, Scolarites1>
     */
    #[ORM\OneToMany(targetEntity: Scolarites1::class, mappedBy: 'niveau', orphanRemoval: true)]
    private Collection $scolarites1s;

    /**
     * @var Collection<int, Scolarites2>
     */
    #[ORM\OneToMany(targetEntity: Scolarites2::class, mappedBy: 'niveau', orphanRemoval: true)]
    private Collection $scolarites2s;

    #[ORM\Column(length: 60)]
    private ?string $designation = null;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->statuts = new ArrayCollection();
        $this->scolarites1s = new ArrayCollection();
        $this->scolarites2s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCycle(): ?Cycles
    {
        return $this->cycle;
    }

    public function setCycle(?Cycles $cycle): static
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): static
    {
        $this->effectif = $effectif;

        return $this;
    }

    /**
     * @return Collection<int, Classes>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setNiveau($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): static
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getNiveau() === $this) {
                $class->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Statuts>
     */
    public function getStatuts(): Collection
    {
        return $this->statuts;
    }

    public function addStatut(Statuts $statut): static
    {
        if (!$this->statuts->contains($statut)) {
            $this->statuts->add($statut);
            $statut->addNiveau($this);
        }

        return $this;
    }

    public function removeStatut(Statuts $statut): static
    {
        if ($this->statuts->removeElement($statut)) {
            $statut->removeNiveau($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Scolarites1>
     */
    public function getScolarites1s(): Collection
    {
        return $this->scolarites1s;
    }

    public function addScolarites1(Scolarites1 $scolarites1): static
    {
        if (!$this->scolarites1s->contains($scolarites1)) {
            $this->scolarites1s->add($scolarites1);
            $scolarites1->setNiveau($this);
        }

        return $this;
    }

    public function removeScolarites1(Scolarites1 $scolarites1): static
    {
        if ($this->scolarites1s->removeElement($scolarites1)) {
            // set the owning side to null (unless already changed)
            if ($scolarites1->getNiveau() === $this) {
                $scolarites1->setNiveau(null);
            }
        }

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
            $scolarites2->setNiveau($this);
        }

        return $this;
    }

    public function removeScolarites2(Scolarites2 $scolarites2): static
    {
        if ($this->scolarites2s->removeElement($scolarites2)) {
            // set the owning side to null (unless already changed)
            if ($scolarites2->getNiveau() === $this) {
                $scolarites2->setNiveau(null);
            }
        }

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }
}
