<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\ClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ClassesRepository::class)]
#[ORM\Table(name: 'classes', indexes: [
    new ORM\Index(name: 'idx_classes_designation', columns: ['designation']),
    new ORM\Index(name: 'idx_classes_niveau', columns: ['niveau_id']),
    new ORM\Index(name: 'idx_classes_disponibilite', columns: ['disponibilite'])],
    options: ['CHECK' => 'disponibilite >= capacite - effectif']
)]
class Classes
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'classes', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id', )]
    private ?Niveaux $niveau = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero()]
    private ?int $capacite = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero()]
    private ?int $effectif = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero()]
    private ?int $disponibilite = null;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'classe')]
    private Collection $eleves;

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    #[Assert\Callback]
    public function validateDisponibilite(ExecutionContextInterface $context): void
    {
        if ($this->effectif > $this->capacite) {
            $context->buildViolation("L'effectif ne peut pas dépasser la capacité de la classe.")
                ->atPath('effectif')
                ->addViolation();
        }

        if ($this->disponibilite !== max(0, $this->capacite - $this->effectif)) {
            $context->buildViolation("La disponibilité doit être égale à la capacité moins l'effectif.")
                ->atPath('disponibilite')
                ->addViolation();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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
        $this->updateDisponibilite();

        return $this;
    }

    public function getDisponibilite(): ?int
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(int $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    private function updateDisponibilite(): void
    {
        $this->disponibilite = max(0, $this->capacite - $this->effectif);
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
            $elefe->setClasse($this);

            // Mettre à jour l'effectif et la disponibilité
            $this->effectif++;
            $this->updateDisponibilite();
        }

        return $this;
        
    }

    public function removeElefe(Eleves $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasse() === $this) {
                $elefe->setClasse(null);
            }

            // Mettre à jour l'effectif et la disponibilité
            $this->effectif--;
            $this->updateDisponibilite();
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
