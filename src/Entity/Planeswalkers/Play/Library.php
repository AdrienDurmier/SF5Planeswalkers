<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_library")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\LibraryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Library extends Area
{
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

    public function addGameCardLibrary(GameCardLibrary $gameCardLibrary)
    {
        $this->gameCardsLibrary[] = $gameCardLibrary;
    }

    public function removeGameCardLibrary(GameCardLibrary $gameCardLibrary)
    {
        $this->gameCardsLibrary->removeElement($gameCardLibrary);
    }

    public function getGameCardsLibrary()
    {
        return $this->gameCardsLibrary;
    }

}
