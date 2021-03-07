<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\Common\Collections\ArrayCollection;
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

    public function __construct()
    {
        switch ($this->getGame()->getFormat()->getCle()) {
            case 'commander':
            case 'brawl':
                $this->lifepoint = 30;
                break;
            default:
                $this->lifepoint = 20;
        }
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

    /**
     * @ORM\OneToOne(targetEntity=Library::class, inversedBy="player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $library;

    /**
     * @ORM\OneToOne(targetEntity=Hand::class, inversedBy="player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $hand;

    /**
     * @ORM\OneToOne(targetEntity=Graveyard::class, inversedBy="player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $graveyard;

    /**
     * @ORM\OneToOne(targetEntity=Exile::class, inversedBy="player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $exile;

    /**
     * @ORM\OneToOne(targetEntity=Battlefield::class, inversedBy="player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $battlefield;

    /**
     * @ORM\OneToOne(targetEntity=CommandZone::class, inversedBy="player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandZone;

    /**
     * @ORM\OneToOne(targetEntity=Sideboard::class, inversedBy="player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sideboard;

    /**
     * @ORM\Column(type="integer")
     */
    private $lifepoint;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rollDiceStartingGame;

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

    public function getLibrary(): ?Library
    {
        return $this->library;
    }

    public function setLibrary(Library $library): self
    {
        $this->library = $library;

        return $this;
    }

    public function getHand(): ?Hand
    {
        return $this->hand;
    }

    public function setHand(Hand $hand): self
    {
        $this->hand = $hand;

        return $this;
    }

    public function getGraveyard(): ?Graveyard
    {
        return $this->graveyard;
    }

    public function setGraveyard(Graveyard $graveyard): self
    {
        $this->graveyard = $graveyard;

        return $this;
    }

    public function getExile(): ?Exile
    {
        return $this->exile;
    }

    public function setExile(Exile $exile): self
    {
        $this->exile = $exile;

        return $this;
    }

    public function getBattlefield(): ?Battlefield
    {
        return $this->battlefield;
    }

    public function setBattlefield(Battlefield $battlefield): self
    {
        $this->battlefield = $battlefield;

        return $this;
    }

    public function getCommandZone(): ?CommandZone
    {
        return $this->commandZone;
    }

    public function setCommandZone(CommandZone $commandZone): self
    {
        $this->commandZone = $commandZone;

        return $this;
    }

    public function getSideboard(): ?Sideboard
    {
        return $this->sideboard;
    }

    public function setSideboard(Sideboard $sideboard): self
    {
        $this->sideboard = $sideboard;

        return $this;
    }

    public function getLifepoint(): ?int
    {
        return $this->lifepoint;
    }

    public function setLifepoint(int $lifepoint): self
    {
        $this->lifepoint = $lifepoint;
        return $this;
    }

    public function getRollDiceStartingGame(): ?int
    {
        return $this->rollDiceStartingGame;
    }

    public function setRollDiceStartingGame(?int $rollDiceStartingGame): self
    {
        $this->rollDiceStartingGame = $rollDiceStartingGame;
        return $this;
    }
}
