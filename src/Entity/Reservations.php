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
    private ?string $eamil = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LastName = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbcouverts = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $scheduledTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mentions_allergene = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Users $ReservationUsers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEamil(): ?string
    {
        return $this->eamil;
    }

    public function setEamil(?string $eamil): self
    {
        $this->eamil = $eamil;

        return $this;
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

    public function getReservationUsers(): ?Users
    {
        return $this->ReservationUsers;
    }

    public function setReservationUsers(?Users $ReservationUsers): self
    {
        $this->ReservationUsers = $ReservationUsers;

        return $this;
    }
}
