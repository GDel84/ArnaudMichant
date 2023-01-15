<?php

namespace App\Entity;

use App\Repository\SetupsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SetupsRepository::class)]
class Setups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clefs = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClefs(): ?string
    {
        return $this->clefs;
    }

    public function setClefs(?string $clefs): self
    {
        $this->clefs = $clefs;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
