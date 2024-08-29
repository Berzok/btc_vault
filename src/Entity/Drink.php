<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DrinkRepository::class)]
class Drink {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $description = null;

    /**
     * @var Collection<int, DrinkIngredients>
     */
    #[ORM\OneToMany(targetEntity: DrinkIngredients::class, mappedBy: 'drink')]
    private Collection $drinkIngredients;

    /**
     * @var Collection<int, Etape>
     */
    #[ORM\OneToMany(targetEntity: Etape::class, mappedBy: 'drink', orphanRemoval: true)]
    private Collection $etapes;

    public function __construct() {
        $this->drinkIngredients = new ArrayCollection();
        $this->etapes = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): static {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, DrinkIngredients>
     */
    public function getDrinkIngredients(): Collection {
        return $this->drinkIngredients;
    }

    public function addDrinkIngredient(DrinkIngredients $drinkIngredient): static {
        if (!$this->drinkIngredients->contains($drinkIngredient)) {
            $this->drinkIngredients->add($drinkIngredient);
            $drinkIngredient->setDrink($this);
        }

        return $this;
    }

    public function removeDrinkIngredient(DrinkIngredients $drinkIngredient): static {
        if ($this->drinkIngredients->removeElement($drinkIngredient)) {
            // set the owning side to null (unless already changed)
            if ($drinkIngredient->getDrink() === $this) {
                $drinkIngredient->setDrink(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection {
        return $this->etapes;
    }

    /**
     * @param Etape $etape
     * @return $this
     */
    public function addEtape(Etape $etape): static {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setDrink($this);
        }

        return $this;
    }

    /**
     * @param Etape $etape
     * @return $this
     */
    public function removeEtape(Etape $etape): static {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getDrink() === $this) {
                $etape->setDrink(null);
            }
        }

        return $this;
    }
}
