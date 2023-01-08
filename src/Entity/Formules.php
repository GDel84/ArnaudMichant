<?php

namespace App\Entity;

use App\Repository\FormulesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormulesRepository::class)]
class Formules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?float $Prices = null;

    #[ORM\ManyToOne(inversedBy: 'CarteFormules')]
    private ?Carte $CarteFormules = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrices(): ?float
    {
        return $this->Prices;
    }

    public function setPrices(?float $Prices): self
    {
        $this->Prices = $Prices;

        return $this;
    }

    public function getCarteFormules(): ?Carte
    {
        return $this->CarteFormules;
    }

    public function setCarteFormules(?Carte $CarteFormules): self
    {
        $this->CarteFormules = $CarteFormules;

        return $this;
    }

}
