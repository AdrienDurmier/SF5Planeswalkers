<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_mana_cost")
 * @ORM\Entity(repositoryClass="App\Repository\Planeswalkers\ManaCostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ManaCost
{
    public function __toString() {
        return $this->symbol;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $symbol;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mana;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getMana(): ?bool
    {
        return $this->mana;
    }

    public function setMana(bool $mana): self
    {
        $this->mana = $mana;

        return $this;
    }

    public function getCmc(): ?string
    {
        return $this->cmc;
    }

    public function setCmc(?string $cmc): self
    {
        $this->cmc = $cmc;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
