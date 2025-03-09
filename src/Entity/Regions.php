<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\RegionsRepository;
use App\Entity\Trait\DesignationTrait;
use App\Entity\Trait\EntityTrackingTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RegionsRepository::class)]
#[ORM\Table(name: 'regions')]
#[ORM\UniqueConstraint(name: 'UNIQ_REGION_DESIGNATION', columns: ['designation'])]
class Regions
{
    use DesignationTrait;
    use SlugTrait;
    use CreatedAtTrait;
    use EntityTrackingTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Cercles>
     */
    #[ORM\OneToMany(targetEntity: Cercles::class, mappedBy: 'region')]
    private Collection $cercles;

    public function __construct()
    {
        $this->cercles = new ArrayCollection();
    }

    public function __tostring()
    {
        return $this->designation ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Cercles>
     */
    public function getCercles(): Collection
    {
        return $this->cercles;
    }

    public function addCercle(Cercles $cercle): static
    {
        if (!$this->cercles->contains($cercle)) {
            $this->cercles->add($cercle);
            $cercle->setRegion($this);
        }

        return $this;
    }

    public function removeCercle(Cercles $cercle): static
    {
        if ($this->cercles->removeElement($cercle)) {
            // set the owning side to null (unless already changed)
            if ($cercle->getRegion() === $this) {
                $cercle->setRegion(null);
            }
        }

        return $this;
    }

    public function hasCercle(Cercles $cercle): bool
    {
        return $this->cercles->contains($cercle);
    }

    public function clearCercles(): static
    {
        $this->cercles->clear();
        return $this;
    }
}
