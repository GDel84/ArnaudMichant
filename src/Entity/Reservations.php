<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LastName = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbcouverts = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $scheduledTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mentions_allergene = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?User $UserResa = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(?string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getNbcouverts(): ?int
    {
        return $this->nbcouverts;
    }

    public function setNbcouverts(?int $nbcouverts): self
    {
        $this->nbcouverts = $nbcouverts;

        return $this;
    }

    public function getScheduledTime(): ?\DateTimeInterface
    {
        return $this->scheduledTime;
    }

    public function setScheduledTime(?\DateTimeInterface $scheduledTime): self
    {
        $this->scheduledTime = $scheduledTime;

        return $this;
    }

    public function getMentionsAllergene(): ?string
    {
        return $this->mentions_allergene;
    }

    public function setMentionsAllergene(?string $mentions_allergene): self
    {
        $this->mentions_allergene = $mentions_allergene;

        return $this;
    }

    public function getUserResa(): ?User
    {
        return $this->UserResa;
    }

    public function setUserResa(?User $UserResa): self
    {
        $this->UserResa = $UserResa;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }


}
