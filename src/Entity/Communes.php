<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\DesignationTrait;
use App\Repository\CommunesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommunesRepository::class)]
class Communes
{
    use DesignationTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'communes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cercles $cercle = null;

    /**
     * @var Collection<int, LieuNaissances>
     */
    #[ORM\OneToMany(targetEntity: LieuNaissances::class, mappedBy: 'commune')]
    private Collection $lieuNaissances;

    public function __construct()
    {
        $this->lieuNaissances = new ArrayCollection();
    }

    public function __tostring()
    {
        return $this->designation ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCercle(): ?Cercles
    {
        return $this->cercle;
    }

    public function setCercle(?Cercles $cercle): static
    {
        $this->cercle = $cercle;

        return $this;
    }

    /**
     * @return Collection<int, LieuNaissances>
     */
    public function getLieuNaissances(): Collection
    {
        return $this->lieuNaissances;
    }

    public function addLieuNaissance(LieuNaissances $lieuNaissance): static
    {
        if (!$this->lieuNaissances->contains($lieuNaissance)) {
            $this->lieuNaissances->add($lieuNaissance);
            $lieuNaissance->setCommune($this);
        }

        return $this;
    }

    public function removeLieuNaissance(LieuNaissances $lieuNaissance): static
    {
        if ($this->lieuNaissances->removeElement($lieuNaissance)) {
            // set the owning side to null (unless already changed)
            if ($lieuNaissance->getCommune() === $this) {
                $lieuNaissance->setCommune(null);
            }
        }

        return $this;
    }

    public function hasLieuNaissance(LieuNaissances $lieu): bool
    {
        return $this->lieuNaissances->contains($lieu);
    }

    public function clearLieuNaissances(): static
    {
        $this->lieuNaissances->clear();
        return $this;
    }
}
