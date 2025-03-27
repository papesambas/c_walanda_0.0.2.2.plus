<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\DesignationTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\EcoleProvenancesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EcoleProvenancesRepository::class)]
class EcoleProvenances
{
    use DesignationTrait;
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 15,
        max: 150,
        minMessage: 'Nom designation must be at least {{ limit }} characters long.',
        maxMessage: 'Nom designation cannot be longer than {{ limit }} characters.'
    )]

    private ?string $adresse = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Assert\Regex(
        pattern: '/^\+\d{3} \d{2} \d{2} \d{2} \d{2}$/',
        message: "Format invalide "
    )]
    private ?string $telephone = null;

    #[ORM\Column(
        length: 180,               // Standard recommandé pour les emails
        unique: true,             // Empêche les doublons
        nullable: true,           // Permet les valeurs null
        options: [
            'collation' => 'utf8mb4_unicode_ci'  // Meilleur support Unicode
        ]
    )]
    #[Assert\Email(
        message: 'L\'email {{ value }} n\'est pas valide.',
        mode: 'strict'            // Validation plus rigoureuse
    )]
    #[Assert\Length(
        max: 180,
        maxMessage: 'L\'email ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $email = null;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'ecoleRecrutement')]
    private Collection $eleves;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\ManyToMany(targetEntity: Eleves::class, mappedBy: 'ecoleAnDernier')]
    private Collection $elevesAnDernier;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->elevesAnDernier = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->designation ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        if ($email !== null) {
            $email = mb_strtolower(trim($email)); // Normalisation
        }
        $this->email = $email;
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
            $elefe->setEcoleRecrutement($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getEcoleRecrutement() === $this) {
                $elefe->setEcoleRecrutement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Eleves>
     */
    public function getElevesAnDernier(): Collection
    {
        return $this->elevesAnDernier;
    }

    public function addElevesAnDernier(Eleves $elevesAnDernier): static
    {
        if (!$this->elevesAnDernier->contains($elevesAnDernier)) {
            $this->elevesAnDernier->add($elevesAnDernier);
            $elevesAnDernier->addEcoleAnDernier($this);
        }

        return $this;
    }

    public function removeElevesAnDernier(Eleves $elevesAnDernier): static
    {
        if ($this->elevesAnDernier->removeElement($elevesAnDernier)) {
            $elevesAnDernier->removeEcoleAnDernier($this);
        }

        return $this;
    }

}
