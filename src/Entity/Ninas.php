<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NinasRepository;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NinasRepository::class)]
class Ninas
{
    use SlugTrait;
    use CreatedAtTrait;
    use EntityTrackingTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15, unique: true)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Length(min: 15, max: 15, minMessage: "La désignation doit contenir au moins {{ limit }} caractères.", maxMessage: "La désignation ne peut pas dépasser {{ limit }} caractères.")]
    #[Assert\Regex(
        pattern: "/^(?=(?:\D*\d){9})(?=(?:\d*[A-Za-z]){1,4})[A-Za-z0-9]+ [A-Za-z]$/",
        message: "La désignation doit contenir au moins 9 chiffres, au plus 4 lettres, un espace en avant-dernière position, et se terminer par une lettre."
    )]
    private ?string $designation = null;

    #[ORM\OneToOne(inversedBy: 'ninas', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true, unique: true)] // <-- Ajoutez unique: true
    private ?Peres $pere = null;

    #[ORM\OneToOne(inversedBy: 'ninas', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true, unique: true)] // <-- Ajoutez unique: true
    private ?Meres $mere = null;

    public function __toString(): string
    {
        return $this->designation ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        // Valide que la chaîne n'est pas vide
        if (empty(trim($designation))) {
            throw new \InvalidArgumentException('La désignation ne peut pas être vide.');
        }

        // Supprime les espaces multiples et les espaces en début/fin de chaîne
        $designation = trim(preg_replace('/\s+/', ' ', $designation));

        // Convertit toutes les lettres en majuscules
        $this->designation = mb_strtoupper($designation, 'UTF-8');

        return $this;
    }

    public function getPere(): ?Peres
    {
        return $this->pere;
    }

    public function setPere(?Peres $pere): static
    {
        $this->pere = $pere;

        return $this;
    }

    public function getMere(): ?Meres
    {
        return $this->mere;
    }

    public function setMere(?Meres $mere): static
    {
        $this->mere = $mere;

        return $this;
    }
}
