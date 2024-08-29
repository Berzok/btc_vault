<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $karmotrine = null;

    /**
     * @var Collection<int, DrinkIngredients>
     */
    #[ORM\OneToMany(targetEntity: DrinkIngredients::class, mappedBy: 'ingredient')]
    private Collection $drinkIngredients;

    public function __construct() {
        $this->drinkIngredients = new ArrayCollection();
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

    public function isKarmotrine(): ?bool {
        return $this->karmotrine;
    }

    public function setKarmotrine(bool $karmotrine): static {
        $this->karmotrine = $karmotrine;

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
            $drinkIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removeDrinkIngredient(DrinkIngredients $drinkIngredient): static {
        if ($this->drinkIngredients->removeElement($drinkIngredient)) {
            // set the owning side to null (unless already changed)
            if ($drinkIngredient->getIngredient() === $this) {
                $drinkIngredient->setIngredient(null);
            }
        }

        return $this;
    }
}
