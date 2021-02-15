<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Planeswalkers\Deck;
use App\Entity\User;

/**
 * @ORM\Table(name="planeswalkers_play_player")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\ExileRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Player
{
    public function __toString()
    {
        return $this->user->getFirstname() . ' ' . $this->user->getLastname();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Play\Game", inversedBy="players")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Deck")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deck;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getGame()
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getDeck()
    {
        return $this->deck;
    }

    public function setDeck(Deck $deck): self
    {
        $this->deck = $deck;
        return $this;
    }
}
