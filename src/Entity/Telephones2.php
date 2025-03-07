<?php

namespace App\Entity;

use App\Repository\Telephones2Repository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: Telephones2Repository::class)]
class Telephones2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 23, unique:true)]
    #[Assert\NotBlank(message: 'phone number cannot be blank.')]
    #[Assert\Length(
        min: 12,
        max: 23,
        minMessage: 'Phone number must be at least {{ limit }} characters long.',
        maxMessage: 'Phone number cannot be longer than {{ limit }} characters.'
    )]
    private ?string $numero = null;

    #[ORM\OneToOne(mappedBy: 'telephone2', cascade: ['persist', 'remove'])]
    private ?Peres $peres = null;

    #[ORM\OneToOne(mappedBy: 'telephone2', cascade: ['persist', 'remove'])]
    private ?Meres $meres = null;

    public function __tostring()
    {
        return $this->numero ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPeres(): ?Peres
    {
        return $this->peres;
    }

    public function setPeres(?Peres $peres): static
    {
        // unset the owning side of the relation if necessary
        if ($peres === null && $this->peres !== null) {
            $this->peres->setTelephone2(null);
        }

        // set the owning side of the relation if necessary
        if ($peres !== null && $peres->getTelephone2() !== $this) {
            $peres->setTelephone2($this);
        }

        $this->peres = $peres;

        return $this;
    }

    public function getMeres(): ?Meres
    {
        return $this->meres;
    }

    public function setMeres(?Meres $meres): static
    {
        // unset the owning side of the relation if necessary
        if ($meres === null && $this->meres !== null) {
            $this->meres->setTelephone2(null);
        }

        // set the owning side of the relation if necessary
        if ($meres !== null && $meres->getTelephone2() !== $this) {
            $meres->setTelephone2($this);
        }

        $this->meres = $meres;

        return $this;
    }
}
