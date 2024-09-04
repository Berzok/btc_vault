<?php

namespace App\Entity;

use App\Repository\DrinkIngredientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: DrinkIngredientsRepository::class)]
class DrinkIngredients {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'drinkIngredients')]
    #[Ignore]
    private ?Drink $drink = null;

    #[ORM\ManyToOne(inversedBy: 'drinkIngredients')]
    #[MaxDepth(1)]
    private ?Ingredient $ingredient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unit = null;

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return Drink|null
     */
    public function getDrink(): ?Drink {
        return $this->drink;
    }

    /**
     * @param Drink|null $drink
     * @return $this
     */
    public function setDrink(?Drink $drink): static {
        $this->drink = $drink;
        return $this;
    }

    /**
     * @return Ingredient|null
     */
    public function getIngredient(): ?Ingredient {
        return $this->ingredient;
    }

    /**
     * @param Ingredient|null $ingredient
     * @return $this
     */
    public function setIngredient(?Ingredient $ingredient): static {
        $this->ingredient = $ingredient;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string {
        return $this->quantity;
    }

    /**
     * @param string|null $quantity
     * @return $this
     */
    public function setQuantity(?string $quantity): static {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string {
        return $this->unit;
    }

    /**
     * @param string|null $unit
     * @return $this
     */
    public function setUnit(?string $unit): static {
        $this->unit = $unit;
        return $this;
    }
}
