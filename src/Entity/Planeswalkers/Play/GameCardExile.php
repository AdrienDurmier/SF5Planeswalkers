<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_gamecardexile")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GameCardExileRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class GameCardExile extends GameCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Exile::class, inversedBy="gameCardsExile")
     */
    private $exile;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    public function getExile(): ?Exile
    {
        return $this->exile;
    }

    public function setExile(?Exile $exile): self
    {
        $this->exile = $exile;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
