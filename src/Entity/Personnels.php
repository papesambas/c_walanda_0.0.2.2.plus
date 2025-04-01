<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\PersonnelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: PersonnelsRepository::class)]
#[Vich\Uploadable]
class Personnels
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

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Noms $nom = null;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prenoms $prenom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LieuNaissances $lieuNaissance = null;

    #[ORM\Column(length: 2)]
    private ?string $sexe = null;

    #[ORM\OneToOne(inversedBy: 'personnels', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Telephones1 $telephone1 = null;

    #[ORM\OneToOne(inversedBy: 'personnels', cascade: ['persist', 'remove'])]
    private ?Telephones2 $telephone2 = null;

    #[ORM\OneToOne(inversedBy: 'personnels', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ninas $nina = null;

    /**
     * @var Collection<int, DossierPersonnel>
     */
    #[ORM\OneToMany(targetEntity: DossierPersonnel::class, mappedBy: 'personnels')]
    private Collection $dossier;

    /**
     * @var Collection<int, Contrats>
     */
    #[ORM\OneToMany(targetEntity: Contrats::class, mappedBy: 'personnels')]
    private Collection $contrat;

    /**
     * @var Collection<int, Specialites>
     */
    #[ORM\ManyToMany(targetEntity: Specialites::class, inversedBy: 'personnels')]
    private Collection $specialites;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?NiveauEtudes $niveauEtudes = null;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Postes $poste = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $referenceDiplome = null;

    /**
     * @var Collection<int, AbsencesPersonnel>
     */
    #[ORM\OneToMany(targetEntity: AbsencesPersonnel::class, mappedBy: 'personnel')]
    private Collection $absencesPersonnels;

    /**
     * @var Collection<int, RetardsPersonnel>
     */
    #[ORM\OneToMany(targetEntity: RetardsPersonnel::class, mappedBy: 'personnel')]
    private Collection $retardsPersonnels;

    /**
     * @var Collection<int, IndisciplinePersonnel>
     */
    #[ORM\OneToMany(targetEntity: IndisciplinePersonnel::class, mappedBy: 'personnel')]
    private Collection $indisciplinePersonnels;

    #[ORM\Column]
    private ?bool $isActif = false;

    #[ORM\Column]
    private ?bool $isAllowed = false;

    public function __construct()
    {
        $this->dossier = new ArrayCollection();
        $this->contrat = new ArrayCollection();
        $this->specialites = new ArrayCollection();
        $this->absencesPersonnels = new ArrayCollection();
        $this->retardsPersonnels = new ArrayCollection();
        $this->indisciplinePersonnels = new ArrayCollection();
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

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeImmutable $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTelephone1(): ?Telephones1
    {
        return $this->telephone1;
    }

    public function setTelephone1(Telephones1 $telephone1): static
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?Telephones2
    {
        return $this->telephone2;
    }

    public function setTelephone2(?Telephones2 $telephone2): static
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    public function getNina(): ?Ninas
    {
        return $this->nina;
    }

    public function setNina(Ninas $nina): static
    {
        $this->nina = $nina;

        return $this;
    }

    /**
     * @return Collection<int, DossierPersonnel>
     */
    public function getDossier(): Collection
    {
        return $this->dossier;
    }

    public function addDossier(DossierPersonnel $dossier): static
    {
        if (!$this->dossier->contains($dossier)) {
            $this->dossier->add($dossier);
            $dossier->setPersonnels($this);
        }

        return $this;
    }

    public function removeDossier(DossierPersonnel $dossier): static
    {
        if ($this->dossier->removeElement($dossier)) {
            // set the owning side to null (unless already changed)
            if ($dossier->getPersonnels() === $this) {
                $dossier->setPersonnels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contrats>
     */
    public function getContrat(): Collection
    {
        return $this->contrat;
    }

    public function addContrat(Contrats $contrat): static
    {
        if (!$this->contrat->contains($contrat)) {
            $this->contrat->add($contrat);
            $contrat->setPersonnels($this);
        }

        return $this;
    }

    public function removeContrat(Contrats $contrat): static
    {
        if ($this->contrat->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getPersonnels() === $this) {
                $contrat->setPersonnels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Specialites>
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialite(Specialites $specialite): static
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites->add($specialite);
        }

        return $this;
    }

    public function removeSpecialite(Specialites $specialite): static
    {
        $this->specialites->removeElement($specialite);

        return $this;
    }

    public function getNiveauEtudes(): ?NiveauEtudes
    {
        return $this->niveauEtudes;
    }

    public function setNiveauEtudes(?NiveauEtudes $niveauEtudes): static
    {
        $this->niveauEtudes = $niveauEtudes;

        return $this;
    }

    public function getPoste(): ?Postes
    {
        return $this->poste;
    }

    public function setPoste(?Postes $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getReferenceDiplome(): ?string
    {
        return $this->referenceDiplome;
    }

    public function setReferenceDiplome(?string $referenceDiplome): static
    {
        $this->referenceDiplome = $referenceDiplome;

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
     * @return Collection<int, AbsencesPersonnel>
     */
    public function getAbsencesPersonnels(): Collection
    {
        return $this->absencesPersonnels;
    }

    public function addAbsencesPersonnel(AbsencesPersonnel $absencesPersonnel): static
    {
        if (!$this->absencesPersonnels->contains($absencesPersonnel)) {
            $this->absencesPersonnels->add($absencesPersonnel);
            $absencesPersonnel->setPersonnel($this);
        }

        return $this;
    }

    public function removeAbsencesPersonnel(AbsencesPersonnel $absencesPersonnel): static
    {
        if ($this->absencesPersonnels->removeElement($absencesPersonnel)) {
            // set the owning side to null (unless already changed)
            if ($absencesPersonnel->getPersonnel() === $this) {
                $absencesPersonnel->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RetardsPersonnel>
     */
    public function getRetardsPersonnels(): Collection
    {
        return $this->retardsPersonnels;
    }

    public function addRetardsPersonnel(RetardsPersonnel $retardsPersonnel): static
    {
        if (!$this->retardsPersonnels->contains($retardsPersonnel)) {
            $this->retardsPersonnels->add($retardsPersonnel);
            $retardsPersonnel->setPersonnel($this);
        }

        return $this;
    }

    public function removeRetardsPersonnel(RetardsPersonnel $retardsPersonnel): static
    {
        if ($this->retardsPersonnels->removeElement($retardsPersonnel)) {
            // set the owning side to null (unless already changed)
            if ($retardsPersonnel->getPersonnel() === $this) {
                $retardsPersonnel->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IndisciplinePersonnel>
     */
    public function getIndisciplinePersonnels(): Collection
    {
        return $this->indisciplinePersonnels;
    }

    public function addIndisciplinePersonnel(IndisciplinePersonnel $indisciplinePersonnel): static
    {
        if (!$this->indisciplinePersonnels->contains($indisciplinePersonnel)) {
            $this->indisciplinePersonnels->add($indisciplinePersonnel);
            $indisciplinePersonnel->setPersonnel($this);
        }

        return $this;
    }

    public function removeIndisciplinePersonnel(IndisciplinePersonnel $indisciplinePersonnel): static
    {
        if ($this->indisciplinePersonnels->removeElement($indisciplinePersonnel)) {
            // set the owning side to null (unless already changed)
            if ($indisciplinePersonnel->getPersonnel() === $this) {
                $indisciplinePersonnel->setPersonnel(null);
            }
        }

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

}
