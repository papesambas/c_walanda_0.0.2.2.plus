<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\DesignationTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\EtablissementsRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EtablissementsRepository::class)]
#[ORM\Table(name: 'etablissements')]
#[ORM\UniqueConstraint(name: 'UNIQ_ENSEIGNEMENT_DESIGNATION', columns: ['designation'])]

class Etablissements
{
    use DesignationTrait;
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'etablissements', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id', )]
    private ?Enseignements $enseignement = null;

    #[ORM\Column(length: 75)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Length(max: 75, maxMessage: "La désignation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $formeJuridique = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: "La décision de création ne peut pas être vide.")]
    #[Assert\Length(max: 50, maxMessage: "La décision de création ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $numDecisionCreation = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: "La décision d'ouverture ne peut pas être vide.")]
    #[Assert\Length(max: 50, maxMessage: "La décision d'ouverture ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $numDecisionOuverture = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotNull(message: "La date de création est obligatoire")]
    #[Assert\LessThanOrEqual(
        value: "now",
        message: "La date de création ne peut pas être postérieure à aujourd'hui"
    )]

    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotNull(message: "La date d'ouverture est obligatoire")]
    #[Assert\LessThanOrEqual(
        value: "now",
        message: "La date d'ouverture ne peut pas être postérieure à aujourd'hui"
    )]
    private ?\DateTimeImmutable $dateOuverture = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $numSocial = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $numFiscal = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $numCpteBancaire = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La désignation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $adresse = null;

    #[ORM\Column(length: 23)]
    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^\+223\s\d{2}\s\d{2}\s\d{2}\s\d{2}$/",
        message: "Le numéro de téléphone doit être au format +223 xx xx xx xx."
    )]
    private ?string $telephone = null;

    #[ORM\Column(length: 23, nullable: true)]
    #[Assert\Regex(
        pattern: "/^\+223\s\d{2}\s\d{2}\s\d{2}\s\d{2}$/",
        message: "Le numéro de téléphone doit être au format +223 xx xx xx xx."
    )]
    private ?string $telephoneMobile = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero()]
    private ?int $capacite = 0;

    #[ORM\Column]
    #[Assert\PositiveOrZero()]
    private ?int $effectif = 0;

    /**
     * @var Collection<int, Cycles>
     */
    #[ORM\OneToMany(targetEntity: Cycles::class, mappedBy: 'etablissement')]
    private Collection $cycles;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'etablissement')]
    private Collection $users;

    #[ORM\Column(length: 130, nullable: true)]
    private ?string $email = null;

    public function __construct()
    {
        $this->cycles = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->designation ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnseignement(): ?Enseignements
    {
        return $this->enseignement;
    }

    public function setEnseignement(?Enseignements $enseignement): static
    {
        $this->enseignement = $enseignement;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(string $formeJuridique): static
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getNumDecisionCreation(): ?string
    {
        return $this->numDecisionCreation;
    }

    public function setNumDecisionCreation(string $numDecisionCreation): static
    {
        $this->numDecisionCreation = $numDecisionCreation;

        return $this;
    }

    public function getNumDecisionOuverture(): ?string
    {
        return $this->numDecisionOuverture;
    }

    public function setNumDecisionOuverture(string $numDecisionOuverture): static
    {
        $this->numDecisionOuverture = $numDecisionOuverture;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateOuverture(): ?\DateTimeImmutable
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(\DateTimeImmutable $dateOuverture): static
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    public function getNumSocial(): ?string
    {
        return $this->numSocial;
    }

    public function setNumSocial(?string $numSocial): static
    {
        $this->numSocial = $numSocial;

        return $this;
    }

    public function getNumFiscal(): ?string
    {
        return $this->numFiscal;
    }

    public function setNumFiscal(?string $numFiscal): static
    {
        $this->numFiscal = $numFiscal;

        return $this;
    }

    public function getNumCpteBancaire(): ?string
    {
        return $this->numCpteBancaire;
    }

    public function setNumCpteBancaire(?string $numCpteBancaire): static
    {
        $this->numCpteBancaire = $numCpteBancaire;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTelephoneMobile(): ?string
    {
        return $this->telephoneMobile;
    }

    public function setTelephoneMobile(?string $telephoneMobile): static
    {
        $this->telephoneMobile = $telephoneMobile;

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
     * @return Collection<int, Cycles>
     */
    public function getCycles(): Collection
    {
        return $this->cycles;
    }

    public function addCycle(Cycles $cycle): static
    {
        if (!$this->cycles->contains($cycle)) {
            $this->cycles->add($cycle);
            $cycle->setEtablissement($this);
        }

        return $this;
    }

    public function removeCycle(Cycles $cycle): static
    {
        if ($this->cycles->removeElement($cycle)) {
            // set the owning side to null (unless already changed)
            if ($cycle->getEtablissement() === $this) {
                $cycle->setEtablissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setEtablissement($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEtablissement() === $this) {
                $user->setEtablissement(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
