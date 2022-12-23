<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Formules::class)]
    private Collection $MenusFormules;

    public function __construct()
    {
        $this->MenusFormules = new ArrayCollection();
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
    public function getMenusFormules(): Collection
    {
        return $this->MenusFormules;
    }

    public function addMenusFormule(Formules $menusFormule): self
    {
        if (!$this->MenusFormules->contains($menusFormule)) {
            $this->MenusFormules->add($menusFormule);
            $menusFormule->setMenus($this);
        }

        return $this;
    }

    public function removeMenusFormule(Formules $menusFormule): self
    {
        if ($this->MenusFormules->removeElement($menusFormule)) {
            // set the owning side to null (unless already changed)
            if ($menusFormule->getMenus() === $this) {
                $menusFormule->setMenus(null);
            }
        }

        return $this;
    }
}
