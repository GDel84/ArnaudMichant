<?php

namespace App\Entity;

use App\Repository\HorairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorairesRepository::class)]
class Horaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DayWeek = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hourly = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $horaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayWeek(): ?string
    {
        return $this->DayWeek;
    }

    public function setDayWeek(?string $DayWeek): self
    {
        $this->DayWeek = $DayWeek;

        return $this;
    }

    public function getHourly(): ?\DateTimeInterface
    {
        return $this->hourly;
    }

    public function sethourly(?\DateTimeInterface $hourly): self
    {
        $this->hourly = $hourly;

        return $this;
    }
}
