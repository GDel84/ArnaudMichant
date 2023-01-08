<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
class Carte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\OneToMany(mappedBy: 'CarteFormules', targetEntity: Formules::class)]
    private Collection $CarteFormules;

    public function __construct()
    {
        $this->CarteFormules = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Formules>
     */
    public function getCarteFormules(): Collection
    {
        return $this->CarteFormules;
    }

    public function addCarteFormule(Formules $carteFormule): self
    {
        if (!$this->CarteFormules->contains($carteFormule)) {
            $this->CarteFormules->add($carteFormule);
            $carteFormule->setCarteFormules($this);
        }

        return $this;
    }

    public function removeCarteFormule(Formules $carteFormule): self
    {
        if ($this->CarteFormules->removeElement($carteFormule)) {
            // set the owning side to null (unless already changed)
            if ($carteFormule->getCarteFormules() === $this) {
                $carteFormule->setCarteFormules(null);
            }
        }

        return $this;
    }
}
