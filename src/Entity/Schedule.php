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

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $noonStartTime = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $noonEndTime = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $nightStartTime = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $nightEndTime = null;

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

    public function getNoonStartTime(): ?\DateTimeImmutable
    {
        return $this->noonStartTime;
    }

    public function setNoonStartTime(?\DateTimeImmutable $noonStartTime): self
    {
        $this->noonStartTime = $noonStartTime;

        return $this;
    }

    public function getNoonEndTime(): ?\DateTimeImmutable
    {
        return $this->noonEndTime;
    }

    public function setNoonEndTime(?\DateTimeImmutable $noonEndTime): self
    {
        $this->noonEndTime = $noonEndTime;

        return $this;
    }

    public function getNightStartTime(): ?\DateTimeImmutable
    {
        return $this->nightStartTime;
    }

    public function setNightStartTime(?\DateTimeImmutable $nightStartTime): self
    {
        $this->nightStartTime = $nightStartTime;

        return $this;
    }

    public function getNightEndTime(): ?\DateTimeImmutable
    {
        return $this->nightEndTime;
    }

    public function setNightEndTime(?\DateTimeImmutable $nightEndTime): self
    {
        $this->nightEndTime = $nightEndTime;

        return $this;
    }
}
