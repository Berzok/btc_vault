<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: DrinkRepository::class)]
#[Vich\Uploadable]
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
    #[MaxDepth(2)]
    private Collection $drinkIngredients;

    /**
     * @var Collection<int, Etape>
     */
    #[ORM\OneToMany(targetEntity: Etape::class, mappedBy: 'drink', orphanRemoval: true)]
    private Collection $etapes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

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

    /**
     * @return string|null
     */
    public function getIcon(): ?string {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * @return $this
     */
    public function setIcon(?string $icon): static {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param string|null $image
     * @return void
     */
    public function setImage(?string $image): void {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string {
        return $this->image;
    }
}
