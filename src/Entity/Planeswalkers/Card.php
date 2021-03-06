<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Table(name="planeswalkers_card")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\CardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Card
{
    public function __toString() {
        return $this->name;
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
    private $idScryfall;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $layout;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrisSmall;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrisNormal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrisLarge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrisPng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrisArtCrop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrisBorderCrop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manaCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $power;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $toughness;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $colors;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cmc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeLine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rarity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdScryfall(): ?string
    {
        return $this->idScryfall;
    }

    public function setIdScryfall(string $idScryfall): self
    {
        $this->idScryfall = $idScryfall;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function setLayout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function getImageUrisSmall(): ?string
    {
        return $this->imageUrisSmall;
    }

    public function setImageUrisSmall(string $imageUrisSmall): self
    {
        $this->imageUrisSmall = $imageUrisSmall;

        return $this;
    }

    public function getImageUrisNormal(): ?string
    {
        return $this->imageUrisNormal;
    }

    public function setImageUrisNormal(string $imageUrisNormal): self
    {
        $this->imageUrisNormal = $imageUrisNormal;

        return $this;
    }

    public function getImageUrisLarge(): ?string
    {
        return $this->imageUrisLarge;
    }

    public function setImageUrisLarge(string $imageUrisLarge): self
    {
        $this->imageUrisLarge = $imageUrisLarge;

        return $this;
    }

    public function getImageUrisPng(): ?string
    {
        return $this->imageUrisPng;
    }

    public function setImageUrisPng(string $imageUrisPng): self
    {
        $this->imageUrisPng = $imageUrisPng;

        return $this;
    }

    public function getImageUrisArtCrop(): ?string
    {
        return $this->imageUrisArtCrop;
    }

    public function setImageUrisArtCrop(string $imageUrisArtCrop): self
    {
        $this->imageUrisArtCrop = $imageUrisArtCrop;

        return $this;
    }

    public function getImageUrisBorderCrop(): ?string
    {
        return $this->imageUrisBorderCrop;
    }

    public function setImageUrisBorderCrop(string $imageUrisBorderCrop): self
    {
        $this->imageUrisBorderCrop = $imageUrisBorderCrop;

        return $this;
    }

    public function getManaCost(): ?string
    {
        return $this->manaCost;
    }

    public function setManaCost(string $manaCost): self
    {
        $this->manaCost = $manaCost;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(?int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getToughness(): ?int
    {
        return $this->toughness;
    }

    public function setToughness(?int $toughness): self
    {
        $this->toughness = $toughness;

        return $this;
    }

    public function getCmc(): ?string
    {
        return $this->cmc;
    }

    public function setCmc(string $cmc): self
    {
        $this->cmc = $cmc;

        return $this;
    }

    public function getTypeLine(): ?string
    {
        return $this->typeLine;
    }

    public function setTypeLine(string $typeLine): self
    {
        $this->typeLine = $typeLine;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function setColors(?array $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

}
