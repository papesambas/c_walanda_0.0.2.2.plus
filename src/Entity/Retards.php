<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\RetardsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetardsRepository::class)]
class Retards
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $jour = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $heure = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $duree = null;

    #[ORM\Column]
    private bool $isJustify = false;

    #[ORM\ManyToOne(inversedBy: 'retards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleves $eleves = null;

    #[ORM\ManyToOne(inversedBy: 'retards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeScolaires $anneeScolaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $heureClasse = null;

    public function __tostring()
    {
        return $this->eleves ?? '';
    }
    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getJour(): ?\DateTimeImmutable
    {
        return $this->jour;
    }
    public function getHeure(): ?\DateTimeImmutable
    {
        return $this->heure;
    }
    public function getDuree(): ?\DateTimeImmutable
    {
        return $this->duree;
    }
    public function isJustify(): bool
    {
        return $this->isJustify;
    }
    public function getEleves(): ?Eleves
    {
        return $this->eleves;
    }
    public function getAnneeScolaire(): ?AnneeScolaires
    {
        return $this->anneeScolaire;
    }
    public function getMotif(): ?string
    {
        return $this->motif;
    }
    
    // Setters
    public function setJour(\DateTimeImmutable $jour): static
    {
        $this->jour = $jour;
        return $this;
    }

    public function setHeure(\DateTimeImmutable $heure): static
    {
        $this->heure = $heure;
        $this->calculerHeureClasse();
        $this->calculerDureeRetard();
        return $this;
    }


    public function setDuree(?\DateTimeImmutable $duree): static
    {
        $this->duree = $duree;
        return $this;
    }

    public function setIsJustify(bool $isJustify): static
    {
        $this->isJustify = $isJustify;
        return $this;
    }

    public function setEleves(?Eleves $eleves): static
    {
        $this->eleves = $eleves;
        return $this;
    }

    public function setAnneeScolaire(?AnneeScolaires $anneeScolaire): static
    {
        $this->anneeScolaire = $anneeScolaire;
        return $this;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;
        return $this;
    }

    private function calculerHeureClasse(): void
    {
        if (!$this->heure) {
            $this->heureClasse = null;
            return;
        }

        $heureArrivee = $this->heure->format('H:i');

        if ($heureArrivee >= '07:30' && $heureArrivee < '10:00') {
            $this->heureClasse = \DateTimeImmutable::createFromFormat('H:i', '07:30');
        } elseif ($heureArrivee >= '10:00' && $heureArrivee < '12:00') {
            $this->heureClasse = \DateTimeImmutable::createFromFormat('H:i', '10:00');
        } elseif ($heureArrivee >= '15:00' && $heureArrivee < '17:00') {
            $this->heureClasse = \DateTimeImmutable::createFromFormat('H:i', '15:00');
        } else {
            $this->heureClasse = null;
        }
    }

    private function calculerDureeRetard(): void
    {
        $this->duree = null;

        if ($this->heure && $this->heureClasse) {
            $diff = $this->heure->getTimestamp() - $this->heureClasse->getTimestamp();

            if ($diff > 0) {
                $this->duree = \DateTimeImmutable::createFromFormat('H:i', '00:00')
                    ->add(new \DateInterval('PT' . $diff . 'S'));
            }
        }
    }

    public function getHeureClasse(): ?\DateTimeImmutable
    {
        return $this->heureClasse;
    }

    public function setHeureClasse(?\DateTimeImmutable $heureClasse): static
    {
        $this->heureClasse = $heureClasse;

        return $this;
    }
}
