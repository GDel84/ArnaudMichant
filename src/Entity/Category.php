<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?float $Prices = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Product $CategoryProduct = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): self
    {
        $this->Title = $Title;

        return $this;
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

    public function getCategoryProduct(): ?Product
    {
        return $this->CategoryProduct;
    }

    public function setCategoryProduct(?Product $CategoryProduct): self
    {
        $this->CategoryProduct = $CategoryProduct;

        return $this;
    }
}
