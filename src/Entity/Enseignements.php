<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\DesignationTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\EnseignementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignementsRepository::class)]
#[ORM\Table(name: 'enseignements')]
#[ORM\UniqueConstraint(name: 'UNIQ_ENSEIGNEMENT_DESIGNATION', columns: ['designation'])]
class Enseignements
{
    use DesignationTrait;
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Etablissements>
     */
    #[ORM\OneToMany(targetEntity: Etablissements::class, mappedBy: 'enseignement')]
    private Collection $etablissements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Etablissements>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissements $etablissement): static
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->setEnseignement($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissements $etablissement): static
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getEnseignement() === $this) {
                $etablissement->setEnseignement(null);
            }
        }

        return $this;
    }

}
