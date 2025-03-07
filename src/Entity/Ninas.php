<?php

namespace App\Entity;

use App\Repository\NinasRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NinasRepository::class)]
class Ninas
{
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
    private ?Peres $pere = null;

    #[ORM\OneToOne(inversedBy: 'ninas', cascade: ['persist', 'remove'])]
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
        $this->designation = $designation;

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