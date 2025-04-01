<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\AnneeScolairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnneeScolairesRepository::class)]
class AnneeScolaires
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', unique: true)]
    private ?int $anneedebut = null;

    #[ORM\Column(type: 'integer', unique: true)]
    private ?int $anneeFin = null;

    /**
     * @var Collection<int, Retards>
     */
    #[ORM\OneToMany(targetEntity: Retards::class, mappedBy: 'anneeScolaire', orphanRemoval: true)]
    private Collection $retards;

    /**
     * @var Collection<int, Absences>
     */
    #[ORM\OneToMany(targetEntity: Absences::class, mappedBy: 'anneeScolaire', orphanRemoval: true)]
    private Collection $absences;

    /**
     * @var Collection<int, Indiscipline>
     */
    #[ORM\OneToMany(targetEntity: Indiscipline::class, mappedBy: 'anneeScolaire', orphanRemoval: true)]
    private Collection $indisciplines;

    #[ORM\Column]
    private ?bool $isCurrent = false;

    /**
     * @var Collection<int, AbsencesPersonnel>
     */
    #[ORM\OneToMany(targetEntity: AbsencesPersonnel::class, mappedBy: 'anneeScolaire')]
    private Collection $absencesPersonnels;

    /**
     * @var Collection<int, RetardsPersonnel>
     */
    #[ORM\OneToMany(targetEntity: RetardsPersonnel::class, mappedBy: 'anneeScolaire')]
    private Collection $retardsPersonnels;

    /**
     * @var Collection<int, IndisciplinePersonnel>
     */
    #[ORM\OneToMany(targetEntity: IndisciplinePersonnel::class, mappedBy: 'anneeScolaire')]
    private Collection $indisciplinePersonnels;

    public function __construct()
    {
        $this->retards = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->indisciplines = new ArrayCollection();
        $this->absencesPersonnels = new ArrayCollection();
        $this->retardsPersonnels = new ArrayCollection();
        $this->indisciplinePersonnels = new ArrayCollection();
    }

    public function __tostring()
    {
        return (string)$this->anneedebut.'-'.(string)$this->anneeFin ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneedebut(): ?int
    {
        return $this->anneedebut;
    }

    public function setAnneedebut(int $anneedebut): static
    {
        $this->anneedebut = $anneedebut;

        return $this;
    }

    public function getAnneeFin(): ?int
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(int $anneeFin): static
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

    /**
     * @return Collection<int, Retards>
     */
    public function getRetards(): Collection
    {
        return $this->retards;
    }

    public function addRetard(Retards $retard): static
    {
        if (!$this->retards->contains($retard)) {
            $this->retards->add($retard);
            $retard->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeRetard(Retards $retard): static
    {
        if ($this->retards->removeElement($retard)) {
            // set the owning side to null (unless already changed)
            if ($retard->getAnneeScolaire() === $this) {
                $retard->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Absences>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absences $absence): static
    {
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeAbsence(Absences $absence): static
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getAnneeScolaire() === $this) {
                $absence->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Indiscipline>
     */
    public function getIndisciplines(): Collection
    {
        return $this->indisciplines;
    }

    public function addIndiscipline(Indiscipline $indiscipline): static
    {
        if (!$this->indisciplines->contains($indiscipline)) {
            $this->indisciplines->add($indiscipline);
            $indiscipline->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeIndiscipline(Indiscipline $indiscipline): static
    {
        if ($this->indisciplines->removeElement($indiscipline)) {
            // set the owning side to null (unless already changed)
            if ($indiscipline->getAnneeScolaire() === $this) {
                $indiscipline->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    public function isCurrent(): ?bool
    {
        return $this->isCurrent;
    }

    public function setIsCurrent(bool $isCurrent): static
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }

    /**
     * Vérifie si cette année scolaire est la dernière enregistrée (la plus récente)
     */
    public function isLatest(AnneeScolairesRepository $repository): bool
    {
        $latestYear = $repository->findLatest();
        return $latestYear && $this->getId() === $latestYear->getId();
    }

    /**
     * Alias pour isLatest() - à utiliser selon votre logique métier
     */
    /*public function isCurrent(AnneeScolairesRepository $repository): bool
    {
        return $this->isLatest($repository);
    }*/

    /**
     * Vérifie si l'année en cours est comprise dans cette période scolaire
     */
    public function includesCurrentYear(): bool
    {
        $currentYear = (int) date('Y');
        return $currentYear >= $this->anneedebut && $currentYear <= $this->anneeFin;
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
            $absencesPersonnel->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeAbsencesPersonnel(AbsencesPersonnel $absencesPersonnel): static
    {
        if ($this->absencesPersonnels->removeElement($absencesPersonnel)) {
            // set the owning side to null (unless already changed)
            if ($absencesPersonnel->getAnneeScolaire() === $this) {
                $absencesPersonnel->setAnneeScolaire(null);
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
            $retardsPersonnel->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeRetardsPersonnel(RetardsPersonnel $retardsPersonnel): static
    {
        if ($this->retardsPersonnels->removeElement($retardsPersonnel)) {
            // set the owning side to null (unless already changed)
            if ($retardsPersonnel->getAnneeScolaire() === $this) {
                $retardsPersonnel->setAnneeScolaire(null);
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
            $indisciplinePersonnel->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeIndisciplinePersonnel(IndisciplinePersonnel $indisciplinePersonnel): static
    {
        if ($this->indisciplinePersonnels->removeElement($indisciplinePersonnel)) {
            // set the owning side to null (unless already changed)
            if ($indisciplinePersonnel->getAnneeScolaire() === $this) {
                $indisciplinePersonnel->setAnneeScolaire(null);
            }
        }

        return $this;
    }
    
}
