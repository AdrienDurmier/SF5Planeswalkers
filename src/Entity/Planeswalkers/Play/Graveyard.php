<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_graveyard")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GraveyardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Graveyard extends Area
{
    public function __construct()
    {
        $this->gameCardsGraveyard = new ArrayCollection();
    }
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="graveyard", cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\Play\GameCardGraveyard", mappedBy="graveyard", cascade={"persist", "remove"})
     */
    private $gameCardsGraveyard;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getGraveyard() !== $this) {
            $player->setGraveyard($this);
        }
        $this->player = $player;
        return $this;
    }

    /**
     * @return Collection|GameCardGraveyard[]
     */
    public function getGameCardsGraveyard(): Collection
    {
        return $this->gameCardsGraveyard;
    }

    public function addGameCardsGraveyard(GameCardGraveyard $gameCardsGraveyard): self
    {
        if (!$this->gameCardsGraveyard->contains($gameCardsGraveyard)) {
            $this->gameCardsGraveyard[] = $gameCardsGraveyard;
            $gameCardsGraveyard->setGraveyard($this);
        }

        return $this;
    }

    public function removeGameCardsGraveyard(GameCardGraveyard $gameCardsGraveyard): self
    {
        if ($this->gameCardsGraveyard->removeElement($gameCardsGraveyard)) {
            if ($gameCardsGraveyard->getGraveyard() === $this) {
                $gameCardsGraveyard->setGraveyard(null);
            }
        }

        return $this;
    }

    public function countGameCardsGraveyard()
    {
        if ($this->gameCardsGraveyard == null) return 0;
        return $this->gameCardsGraveyard->count();
    }
}
