<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $week = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $scheduleMoon = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $scheduleNight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeek(): ?string
    {
        return $this->week;
    }

    public function setWeek(?string $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getScheduleMoon(): ?string
    {
        return $this->scheduleMoon;
    }

    public function setScheduleMoon(?string $scheduleMoon): self
    {
        $this->scheduleMoon = $scheduleMoon;

        return $this;
    }

    public function getScheduleNight(): ?string
    {
        return $this->scheduleNight;
    }

    public function setScheduleNight(?string $scheduleNight): self
    {
        $this->scheduleNight = $scheduleNight;

        return $this;
    }
}
