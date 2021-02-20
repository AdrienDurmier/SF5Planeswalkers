<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_hand")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\HandRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Hand extends Area
{
    public function __construct()
    {
        $this->gameCardsHand = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="hand", cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\Play\GameCardHand", mappedBy="hand", cascade={"persist", "remove"})
     */
    private $gameCardsHand;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getHand() !== $this) {
            $player->setHand($this);
        }
        $this->player = $player;
        return $this;
    }

    /**
     * @return Collection|GameCardHand[]
     */
    public function getGameCardsHand(): Collection
    {
        return $this->gameCardsHand;
    }

    public function addGameCardsHand(GameCardHand $gameCardsHand): self
    {
        if (!$this->gameCardsHand->contains($gameCardsHand)) {
            $this->gameCardsHand[] = $gameCardsHand;
            $gameCardsHand->setHand($this);
        }

        return $this;
    }

    public function removeGameCardsHand(GameCardHand $gameCardsHand): self
    {
        if ($this->gameCardsHand->removeElement($gameCardsHand)) {
            if ($gameCardsHand->getHand() === $this) {
                $gameCardsHand->setHand(null);
            }
        }

        return $this;
    }

    public function countGameCardsHand()
    {
        if ($this->gameCardsHand == null) return 0;
        return $this->gameCardsHand->count();
    }

}
