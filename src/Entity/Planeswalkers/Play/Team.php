<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_team")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\TeamRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var Game
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Play\Game", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\Play\Player", mappedBy="team", cascade={"persist", "remove"})
     */
    private $players;

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): void
    {
        $this->game = $game;
    }

    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    public function removePlayer(Player $player)
    {
        $this->players->removeElement($player);
    }

    public function getPlayers()
    {
        return $this->players;
    }
}
