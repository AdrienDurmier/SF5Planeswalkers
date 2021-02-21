<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_exile")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\ExileRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Exile extends Area
{
    public function __construct()
    {
        $this->gameCardsExile = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="exile", cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\Play\GameCardExile", mappedBy="exile", cascade={"persist", "remove"})
     */
    private $gameCardsExile;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getExile() !== $this) {
            $player->setExile($this);
        }
        $this->player = $player;
        return $this;
    }

    public function getGameCardsExile(): ?Collection
    {
        return $this->gameCardsExile;
    }

    public function addGameCardsExile(GameCardExile $gameCardsExile): self
    {
        if (!$this->gameCardsExile->contains($gameCardsExile)) {
            $this->gameCardsExile[] = $gameCardsExile;
            $gameCardsExile->setExile($this);
        }

        return $this;
    }

    public function removeGameCardsExile(GameCardExile $gameCardsExile): self
    {
        if ($this->gameCardsExile->removeElement($gameCardsExile)) {
            if ($gameCardsExile->getExile() === $this) {
                $gameCardsExile->setExile(null);
            }
        }

        return $this;
    }

    public function countGameCardsExile()
    {
        if ($this->gameCardsExile == null) return 0;
        return $this->gameCardsExile->count();
    }
}
