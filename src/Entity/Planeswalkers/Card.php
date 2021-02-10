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
    private $id_scryfall;

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
    private $image_uris_small;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_uris_normal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_uris_large;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_uris_png;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_uris_art_crop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_uris_border_crop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mana_cost;

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
    private $type_line;

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
        return $this->id_scryfall;
    }

    public function setIdScryfall(string $id_scryfall): self
    {
        $this->id_scryfall = $id_scryfall;

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
        return $this->image_uris_small;
    }

    public function setImageUrisSmall(string $image_uris_small): self
    {
        $this->image_uris_small = $image_uris_small;

        return $this;
    }

    public function getImageUrisNormal(): ?string
    {
        return $this->image_uris_normal;
    }

    public function setImageUrisNormal(string $image_uris_normal): self
    {
        $this->image_uris_normal = $image_uris_normal;

        return $this;
    }

    public function getImageUrisLarge(): ?string
    {
        return $this->image_uris_large;
    }

    public function setImageUrisLarge(string $image_uris_large): self
    {
        $this->image_uris_large = $image_uris_large;

        return $this;
    }

    public function getImageUrisPng(): ?string
    {
        return $this->image_uris_png;
    }

    public function setImageUrisPng(string $image_uris_png): self
    {
        $this->image_uris_png = $image_uris_png;

        return $this;
    }

    public function getImageUrisArtCrop(): ?string
    {
        return $this->image_uris_art_crop;
    }

    public function setImageUrisArtCrop(string $image_uris_art_crop): self
    {
        $this->image_uris_art_crop = $image_uris_art_crop;

        return $this;
    }

    public function getImageUrisBorderCrop(): ?string
    {
        return $this->image_uris_border_crop;
    }

    public function setImageUrisBorderCrop(string $image_uris_border_crop): self
    {
        $this->image_uris_border_crop = $image_uris_border_crop;

        return $this;
    }

    public function getManaCost(): ?string
    {
        return $this->mana_cost;
    }

    public function setManaCost(string $mana_cost): self
    {
        $this->mana_cost = $mana_cost;

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
        return $this->type_line;
    }

    public function setTypeLine(string $type_line): self
    {
        $this->type_line = $type_line;

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
