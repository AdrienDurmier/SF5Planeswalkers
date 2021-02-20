<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_library")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\LibraryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Library extends Area
{
    public function __construct()
    {
        $this->gameCardsLibrary = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="library", cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\Play\GameCardLibrary", mappedBy="library", cascade={"persist", "remove"})
     */
    private $gameCardsLibrary;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getLibrary() !== $this) {
            $player->setLibrary($this);
        }
        $this->player = $player;
        return $this;
    }

    /**
     * @return Collection|GameCardLibrary[]
     */
    public function getGameCardsLibrary(): Collection
    {
        return $this->gameCardsLibrary;
    }

    public function addGameCardsLibrary(GameCardLibrary $gameCardsLibrary): self
    {
        if (!$this->gameCardsLibrary->contains($gameCardsLibrary)) {
            $this->gameCardsLibrary[] = $gameCardsLibrary;
            $gameCardsLibrary->setLibrary($this);
        }

        return $this;
    }

    public function removeGameCardsLibrary(GameCardLibrary $gameCardsLibrary): self
    {
        if ($this->gameCardsLibrary->removeElement($gameCardsLibrary)) {
            if ($gameCardsLibrary->getLibrary() === $this) {
                $gameCardsLibrary->setLibrary(null);
            }
        }

        return $this;
    }

    public function countGameCardsLibrary()
    {
        if ($this->gameCardsLibrary == null) return 0;
        return $this->gameCardsLibrary->count();
    }

}
