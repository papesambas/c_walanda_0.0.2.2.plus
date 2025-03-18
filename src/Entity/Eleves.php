<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\ElevesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ElevesRepository::class)]
#[Vich\Uploadable]

class Eleves
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'eleves_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id',)]
    #[Assert\NotNull(message: "Le nom est obligatoire")]
    private ?Noms $nom = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id',)]
    #[Assert\NotNull(message: "Le prénom est obligatoire")]

    private ?Prenoms $prenom = null;

    // Pour le sexe
    #[ORM\Column(length: 1)]
    #[Assert\Choice(choices: ['M', 'F'], message: "Le sexe doit être 'M' ou 'F'")]
    private ?string $sexe = 'M';

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id',)]
    private ?LieuNaissances $lieuNaissance = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateInscription = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateRecrutement = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id',)]
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
    private ?bool $isActif = false;

    #[ORM\Column]
    private ?bool $isAllowed = false;

    #[ORM\Column]
    private ?bool $isAdmis = false;

    #[ORM\Column]
    private ?bool $isHandicap = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $natureHandicape = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullname = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id',)]
    private ?Users $user = null;

    #[ORM\Column(length: 1)]
    #[Assert\Choice(choices: ['P', 'B', 'E'], message: "Le Statut Financier doit être 'P' ou 'B' ou 'E")]
    private ?string $statutFinance = 'P';

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id')]
    private ?Classes $classe = null;

    #[ORM\ManyToOne(inversedBy: 'eleves', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id',)]
    private ?Statuts $statut = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Scolarites1 $scolarite1 = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Scolarites2 $scolarite2 = null;

    /**
     * @var Collection<int, DossierEleves>
     */
    #[ORM\OneToMany(targetEntity: DossierEleves::class, mappedBy: 'eleves', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $dossierEleves;

    #[ORM\OneToOne(mappedBy: 'eleve', cascade: ['persist', 'remove'])]
    private ?Users $users = null;

    /**
     * @var Collection<int, Departs>
     */
    #[ORM\OneToMany(targetEntity: Departs::class, mappedBy: 'eleve', orphanRemoval: true, cascade: ['persist'])]
    private Collection $departs;

    /**
     * @var Collection<int, Santes>
     */
    #[ORM\OneToMany(targetEntity: Santes::class, mappedBy: 'eleve')]
    private Collection $santes;

    public function __construct()
    {
        $this->dossierEleves = new ArrayCollection();
        $this->departs = new ArrayCollection();
        $this->santes = new ArrayCollection();
    }

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

    public function isAdmis(): ?bool
    {
        return $this->isAdmis;
    }

    public function setisAdmis(bool $isAdmis): static
    {
        $this->isAdmis = $isAdmis;

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

        /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection<int, DossierEleves>
     */
    public function getDossierEleves(): Collection
    {
        return $this->dossierEleves;
    }

    public function addDossierElefe(DossierEleves $dossierElefe): static
    {
        if (!$this->dossierEleves->contains($dossierElefe)) {
            $this->dossierEleves->add($dossierElefe);
            $dossierElefe->setEleves($this);
        }

        return $this;
    }

    public function removeDossierElefe(DossierEleves $dossierElefe): static
    {
        if ($this->dossierEleves->removeElement($dossierElefe)) {
            // set the owning side to null (unless already changed)
            if ($dossierElefe->getEleves() === $this) {
                $dossierElefe->setEleves(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        // unset the owning side of the relation if necessary
        if ($users === null && $this->users !== null) {
            $this->users->setEleve(null);
        }

        // set the owning side of the relation if necessary
        if ($users !== null && $users->getEleve() !== $this) {
            $users->setEleve($this);
        }

        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Departs>
     */
    public function getDeparts(): Collection
    {
        return $this->departs;
    }

    public function addDepart(Departs $depart): static
    {
        if (!$this->departs->contains($depart)) {
            $this->departs->add($depart);
            $depart->setEleve($this);
        }

        return $this;
    }

    public function removeDepart(Departs $depart): static
    {
        if ($this->departs->removeElement($depart)) {
            // set the owning side to null (unless already changed)
            if ($depart->getEleve() === $this) {
                $depart->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Santes>
     */
    public function getSantes(): Collection
    {
        return $this->santes;
    }

    public function addSante(Santes $sante): static
    {
        if (!$this->santes->contains($sante)) {
            $this->santes->add($sante);
            $sante->setEleve($this);
        }

        return $this;
    }

    public function removeSante(Santes $sante): static
    {
        if ($this->santes->removeElement($sante)) {
            // set the owning side to null (unless already changed)
            if ($sante->getEleve() === $this) {
                $sante->setEleve(null);
            }
        }

        return $this;
    }

}
