<?php

namespace App\Entity;

use App\Repository\EtapeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: EtapeRepository::class)]
#[ORM\UniqueConstraint(name: 'etape_unique', columns: ['drink_id', 'content'])]
class Etape {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 511)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'etapes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Drink $drink = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $step = null;

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): static {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static {
        $this->content = $content;

        return $this;
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
     * @return int|null
     */
    public function getStep(): ?int {
        return $this->step;
    }

    /**
     * @param int $step
     * @return $this
     */
    public function setStep(int $step): static {
        $this->step = $step;

        return $this;
    }
}
