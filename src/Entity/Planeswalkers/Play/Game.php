<?php

namespace App\Entity\Planeswalkers\Play;

use App\Entity\Planeswalkers\Legality;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_game")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GameRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Game
{
    const STEP_BEGIN_UNTAP = 0;
    const STEP_BEGIN_UPKEEP = 1;
    const STEP_BEGIN_DRAW = 2;
    const STEP_MAIN_PRECOMBAT = 3;
    const STEP_COMBAT_BEGINNING = 4;
    const STEP_COMBAT_ATTACKERS = 5;
    const STEP_COMBAT_BLOCKERS = 6;
    const STEP_COMBAT_DAMAGE = 7;
    const STEP_COMBAT_END = 8;
    const STEP_MAIN_POSTCOMBAT = 9;
    const STEP_END_TURN = 10;
    const STEP_END_CLEAN = 11;
    const STEP_NEXT = 12;

    public function __construct() {
        $this->created = new \Datetime();
        $this->updated = new \Datetime();
        $this->turn = 1;
        $this->step = self::STEP_BEGIN_UNTAP;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Legality")
     * @ORM\JoinColumn(nullable=false)
     */
    private $format;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\Play\Player", mappedBy="game", cascade={"persist", "remove"})
     */
    private $players;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Play\Player")
     * @ORM\JoinColumn(nullable=true)
     */
    private $playerActive;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $turn;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $step;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate() {
        $this->setUpdated(new \Datetime());
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function getFormat(): Legality
    {
        return $this->format;
    }

    public function setLegality(?Legality $format): void
    {
        $this->format = $format;
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

    public function getPlayerActive(): ?Player
    {
        return $this->playerActive;
    }

    public function setPlayerActive(?Player $playerActive): self
    {
        $this->playerActive = $playerActive;
        return $this;
    }

    public function getPlayer(User $user): ?Player
    {
        foreach($this->players as $player){
            if ($player->getUser() == $user){
                return $player;
            }
        }
        return null;
    }

    public function getOpponent(User $user): ?Player
    {
        // Recherche des adversaires
        $currentPlayer = null;
        foreach($this->players as $player){
            if ($player->getUser() != $user){
                return $player;
            }else{
                $currentPlayer = $player;
            }
        }
        // sinon le joueur s'affronte lui-meme
        return $currentPlayer;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(?int $turn): self
    {
        $this->turn = $turn;
        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(?int $step): self
    {
        $this->step = $step;
        return $this;
    }

}
