<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_battlefield")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\BattlefieldRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Battlefield extends Area
{
    public function __construct()
    {
        $this->gameCardsBattlefield = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="battlefield", cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\Play\GameCardBattlefield", mappedBy="battlefield", cascade={"persist", "remove"})
     */
    private $gameCardsBattlefield;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getBattlefield() !== $this) {
            $player->setBattlefield($this);
        }
        $this->player = $player;
        return $this;
    }

    public function getGameCardsBattlefield(): ?Collection
    {
        return $this->gameCardsBattlefield;
    }

    public function addGameCardsBattlefield(GameCardBattlefield $gameCardsBattlefield): self
    {
        if (!$this->gameCardsBattlefield->contains($gameCardsBattlefield)) {
            $this->gameCardsBattlefield[] = $gameCardsBattlefield;
            $gameCardsBattlefield->setBattlefield($this);
        }

        return $this;
    }

    public function removeGameCardsBattlefield(GameCardBattlefield $gameCardsBattlefield): self
    {
        if ($this->gameCardsBattlefield->removeElement($gameCardsBattlefield)) {
            if ($gameCardsBattlefield->getBattlefield() === $this) {
                $gameCardsBattlefield->setBattlefield(null);
            }
        }

        return $this;
    }

    public function countGameCardsBattlefield()
    {
        if ($this->gameCardsBattlefield == null) return 0;
        return $this->gameCardsBattlefield->count();
    }
}
