<?php

namespace App\Entity;

use App\Repository\ElevesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ElevesRepository::class)]

class Eleves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: 'id',)]
    #[Assert\NotNull(message: "Le nom est obligatoire")]
    private ?Noms $nom = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: 'id',)]
    #[Assert\NotNull(message: "Le prénom est obligatoire")]

    private ?Prenoms $prenom = null;

    // Pour le sexe
    #[ORM\Column(length: 1)]
    #[Assert\Choice(choices: ['M', 'F'], message: "Le sexe doit être 'M' ou 'F'")]
    private ?string $sexe = 'M';

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: 'id',)]
    private ?LieuNaissances $lieuNaissance = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateInscription = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateRecrutement = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: 'id',)]
    private ?Parents $parent = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateExtrait = null;

    // Pour le numéro d'extrait
    #[ORM\Column(name: 'numero_extrait', length: 30, unique: true)]
    #[Assert\NotBlank(message: "Le numéro d'extrait est obligatoire")]
    #[Assert\Regex(
        pattern: "/^[A-Z0-9-]{5,30}$/",
        message: "Format invalide (lettres majuscules, chiffres et tirets)"
    )]
    private ?string $numeroExtrait = null;

    #[ORM\Column]
    private ?bool $isActif = true;

    #[ORM\Column]
    private ?bool $isAllowed = false;

    #[ORM\Column]
    private ?bool $isAdmin = true;

    #[ORM\Column]
    private ?bool $isHandicap = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $natureHandicape = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullname = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id', )]
    private ?Users $user = null;

    #[ORM\Column(length: 1)]
    #[Assert\Choice(choices: ['P', 'B', 'E'], message: "Le Statut Financier doit être 'P' ou 'B' ou 'E")]
    private ?string $statutFinance = 'P';

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id')]
    private ?Classes $classe = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id', )]
    private ?Statuts $statut = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Scolarites1 $scolarite1 = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Scolarites2 $scolarite2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?Noms
    {
        return $this->nom;
    }

    public function setNom(?Noms $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?Prenoms
    {
        return $this->prenom;
    }

    public function setPrenom(?Prenoms $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getLieuNaissance(): ?LieuNaissances
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?LieuNaissances $lieuNaissance): static
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->dateInscription;
    }

    public function setDateInscription($dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getDateRecrutement(): ?\DateTimeImmutable
    {
        return $this->dateRecrutement;
    }

    public function setDateRecrutement($dateRecrutement): static
    {
        $this->dateRecrutement = $dateRecrutement;

        return $this;
    }

    public function getParent(): ?Parents
    {
        return $this->parent;
    }

    public function setParent(?Parents $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance($dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateExtrait(): ?\DateTimeImmutable
    {
        return $this->dateExtrait;
    }

    public function setDateExtrait($dateExtrait): static
    {
        $this->dateExtrait = $dateExtrait;

        return $this;
    }

    public function getNumeroExtrait(): ?string
    {
        return $this->numeroExtrait;
    }

    public function setNumeroExtrait(string $numeroExtrait): static
    {
        $this->numeroExtrait = strtoupper(trim($numeroExtrait));
        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): static
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function isAllowed(): ?bool
    {
        return $this->isAllowed;
    }

    public function setIsAllowed(bool $isAllowed): static
    {
        $this->isAllowed = $isAllowed;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function isHandicap(): ?bool
    {
        return $this->isHandicap;
    }

    public function setIsHandicap(bool $isHandicap): static
    {
        $this->isHandicap = $isHandicap;

        return $this;
    }

    public function getNatureHandicape(): ?string
    {
        return $this->natureHandicape;
    }

    public function setNatureHandicape(?string $natureHandicape): static
    {
        $this->natureHandicape = $natureHandicape;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStatutFinance(): ?string
    {
        return $this->statutFinance;
    }

    public function setStatutFinance(string $statutFinance): static
    {
        $this->statutFinance = $statutFinance;

        return $this;
    }

    public function getClasse(): ?Classes
    {
        return $this->classe;
    }

    public function setClasse(?Classes $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getStatut(): ?Statuts
    {
        return $this->statut;
    }

    public function setStatut(?Statuts $statut): static
    {
        $this->statut = $statut;

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

    public function getScolarite2(): ?Scolarites2
    {
        return $this->scolarite2;
    }

    public function setScolarite2(?Scolarites2 $scolarite2): static
    {
        $this->scolarite2 = $scolarite2;

        return $this;
    }
}
