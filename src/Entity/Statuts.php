<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\StatutsRepository;
use App\Entity\Trait\DesignationTrait;
use App\Entity\Trait\EntityTrackingTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: StatutsRepository::class)]
#[ORM\Table(name: 'statuts')]
#[ORM\UniqueConstraint(name: 'UNIQ_STATUT_DESIGNATION', columns: ['designation'])]
class Statuts
{
    use SlugTrait;
    use CreatedAtTrait;
    use EntityTrackingTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Niveaux>
     */
    #[ORM\ManyToMany(targetEntity: Niveaux::class, inversedBy: 'statuts')]
    //#[ORM\JoinTable(name: 'statuts_niveaux')]
    private Collection $niveaux;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'statut')]
    private Collection $eleves;

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Niveaux>
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveaux $niveau): static
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux->add($niveau);
        }

        return $this;
    }

    public function removeNiveau(Niveaux $niveau): static
    {
        $this->niveaux->removeElement($niveau);

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
            $elefe->setStatut($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getStatut() === $this) {
                $elefe->setStatut(null);
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
