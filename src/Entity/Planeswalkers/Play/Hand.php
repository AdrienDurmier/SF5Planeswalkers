<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_hand")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\HandRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Hand extends Area
{
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
}
